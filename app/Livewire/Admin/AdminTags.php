<?php

namespace App\Livewire\Admin;

use App\Models\Tag;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Support\HtmlString;

#[Layout('layouts.bare')]
class AdminTags extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    protected function tagFormSchema(?Tag $record = null): array
    {
        return [
            Forms\Components\TextInput::make('name')
                ->label('Tag Name')
                ->placeholder('e.g. Python')
                ->required()
                ->minLength(2)
                ->maxLength(50)
                ->unique(table: Tag::class, column: 'name', ignoreRecord: true),

            Forms\Components\ColorPicker::make('color')
                ->label('Text Color')
                ->default('#1e3a5f')
                ->required(),

            Forms\Components\ColorPicker::make('bg')
                ->label('Background')
                ->default('#dbeafe')
                ->required(),
        ];
    }

    protected function mutateTagFormData(array $data): array
    {
        $data['slug'] = Str::slug($data['name']);

        return $data;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Tag::query())
            ->striped()
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Tag')
                    ->searchable()
                    ->sortable()
                    ->html()
                    ->formatStateUsing(fn (string $state, Tag $record) => new HtmlString(
                        '<span style="color: ' . e($record->color) . '; background-color: ' . e($record->bg) . '" class="inline-flex items-center px-2.5 py-1 rounded text-xs font-semibold">' . e($state) . '</span>'
                    )),

                Tables\Columns\TextColumn::make('color')
                    ->label('Colors')
                    ->html()
                    ->formatStateUsing(fn (Tag $record) => new HtmlString(
                        '<div class="flex items-center gap-2">'
                        . '<span class="inline-flex items-center gap-1.5 font-mono text-xs text-brand-muted"><span class="w-3.5 h-3.5 rounded-sm border border-brand-border shrink-0" style="background-color: ' . e($record->color) . '"></span>' . e($record->color) . '</span>'
                        . '<span class="text-brand-muted/40">/</span>'
                        . '<span class="inline-flex items-center gap-1.5 font-mono text-xs text-brand-muted"><span class="w-3.5 h-3.5 rounded-sm border border-brand-border shrink-0" style="background-color: ' . e($record->bg) . '"></span>' . e($record->bg) . '</span>'
                        . '</div>'
                    )),

                Tables\Columns\TextColumn::make('job_listings_count')
                    ->label('Jobs')
                    ->counts('jobListings')
                    ->sortable()
                    ->alignCenter()
                    ->color('info'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Added')
                    ->since()
                    ->sortable()
                    ->color('gray'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('New Tag')
                    ->form(fn () => $this->tagFormSchema())
                    ->mutateFormDataUsing(fn (array $data) => $this->mutateTagFormData($data)),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->form(fn (Tag $record) => $this->tagFormSchema($record))
                    ->mutateFormDataUsing(fn (array $data) => $this->mutateTagFormData($data)),

                Tables\Actions\DeleteAction::make(),
            ])
            ->defaultSort('created_at', 'desc')
            ->emptyStateIcon('heroicon-o-tag')
            ->emptyStateHeading('No tags')
            ->emptyStateDescription('Create a tag to start categorizing job listings.');
    }

    public function render()
    {
        return view('livewire.admin.tags');
    }
}
