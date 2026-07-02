<?php

namespace App\Services;

use App\Models\JobListing;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Smalot\PdfParser\Parser;
use Illuminate\Support\Str;

class ChatbotService
{
    private string $apiKey;
    private string $model;

    public function __construct()
    {
        $this->apiKey = config('services.gemini.key');
        $this->model = config('services.gemini.model');
    }

    public function chat(string $userMessage, array $history = [], ?string $cvText = null): string
    {
        $context = $this->buildContext($cvText);

        $messages = [];

        foreach ($history as $msg) {
            $messages[] = [
                'role' => $msg['role'],
                'parts' => [['text' => $msg['content']]],
            ];
        }

        $messages[] = [
            'role' => 'user',
            'parts' => [['text' => $userMessage]],
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post("https://generativelanguage.googleapis.com/v1beta/models/{$this->model}:generateContent?key={$this->apiKey}", [
            'system_instruction' => [
                'parts' => [['text' => $context]],
            ],
            'contents' => $messages,
        ]);

        return $response->json('candidates.0.content.parts.0.text')
            ?? 'عذراً، حدث خطأ.';
    }

    public function extractTextFromFile(string $storagePath): ?string
    {
        try {
            $fullPath = Storage::disk('public')->path($storagePath);

            if (!file_exists($fullPath)) return null;

            $extension = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));

            if ($extension === 'pdf') {
                $parser = new \Smalot\PdfParser\Parser();
                $pdf = $parser->parseFile($fullPath);
                return \Str::limit($pdf->getText(), 3000);
            }

            if (in_array($extension, ['doc', 'docx'])) {
                $phpWord = \PhpOffice\PhpWord\IOFactory::load($fullPath);
                $text = '';
                foreach ($phpWord->getSections() as $section) {
                    foreach ($section->getElements() as $element) {
                        if (method_exists($element, 'getText')) {
                            $text .= $element->getText() . "\n";
                        }
                    }
                }
                return \Str::limit($text, 3000);
            }

            return null;
        } catch (\Exception $e) {
            return null;
        }
    }

    private function buildContext(?string $cvText = null): string
    {
        $jobs = JobListing::with('tags')
            ->latest()
            ->take(20)
            ->get()
            ->map(fn($job) => [
                'title' => $job->title,
                'company' => $job->company_name,
                'type' => $job->type,
                'location' => $job->location,
                'tags' => $job->tags->pluck('name')->join(', '),
                'description' => Str::limit($job->description, 200),
            ]);

        $cvSection = $cvText
            ? "معلومات المستخدم من سيرته الذاتية:\n{$cvText}\n\n"
            : "المستخدم لم يرفع سيرة ذاتية بعد.\n\n";

        return "أنت مساعد ذكي لمنصة توظيف. مهمتك مساعدة المستخدمين في إيجاد وظائف مناسبة.

{$cvSection}
الوظائف المتاحة حالياً:
{$jobs->toJson(JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)}

تعليمات:
- إذا كان لديك معلومات عن المستخدم من سيرته الذاتية، استخدمها لاقتراح الوظائف الأنسب له تحديداً
- اذكر سبب اقتراحك لكل وظيفة (مثلاً: لأن لديك خبرة في React)
- إذا لم تجد وظيفة مناسبة، أخبر المستخدم بذلك بأدب
- كن مختصراً وواضحاً";
    }
}
