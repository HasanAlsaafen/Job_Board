<?php

namespace App\Livewire\Admin;

use App\Models\Applications;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;

#[Layout('layouts.bare')]
class AdminApplications extends Component implements HasForms, HasTable
{
    use InteractsWithForms, InteractsWithTable;
    public function table(Table $table): Table
    {
        return $table
            ->query(Applications::query()->with(['jobListing', 'user']))
            ->striped()
            ->columns([
                Tables\Columns\TextColumn::make('jobListing.title')
                    ->searchable()
                    ->sortable()
                    ->weight('semibold'),

                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->sortable()
                    ->color('gray'),

                Tables\Columns\TextColumn::make('user.email')
                    ->searchable()
                    ->sortable()
                    ->color('gray'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Applied On')
                    ->since()
                    ->sortable()
                    ->color('gray'),
            ])

            ->actions([
                Tables\Actions\ViewAction::make()
                    ->mutateRecordDataUsing(function (array $data, $record): array {
                        $data['job_title'] = $record->jobListing?->title;
                        $data['applicant_name'] = $record->user?->name;
                        $data['applicant_email'] = $record->user?->email;
                        return $data;
                    })
                    ->form([
                        Forms\Components\TextInput::make('job_title')
                            ->label('Job Title')
                            ->disabled(),

                        Forms\Components\TextInput::make('applicant_name')
                            ->label('Applicant Name')
                            ->disabled(),

                        Forms\Components\TextInput::make('applicant_email')
                            ->label('Applicant Email')
                            ->disabled(),

                        Forms\Components\Textarea::make('cover_letter')
                            ->label('Cover Letter')
                            ->disabled(),

                        Forms\Components\FileUpload::make('resume_path')
                            ->label('Resume')
                            ->disabled()
                            ->downloadable()
                            ->directory('resumes'),
                    ]),

            ]);
    }
    public function render()
    {
        return view('livewire.admin.applications');
    }
}
