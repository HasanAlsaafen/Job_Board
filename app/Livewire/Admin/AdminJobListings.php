<?php

namespace App\Livewire\Admin;

use App\Models\JobListing;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Filament\Infolists;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Columns\Summarizers\Sum;

#[Layout('layouts.bare')]

class AdminJobListings extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(JobListing::query()->with(['tags', 'user']))
            ->striped()
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->weight('semibold')
                    ->description(fn($record) => $record->company_name)
                    ->wrap(),

                Tables\Columns\TextColumn::make('location')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-m-map-pin')
                    ->iconColor('gray')
                    ->placeholder('—'),

                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->color(fn($state) => match ($state) {
                        'remote'  => 'success',
                        'hybrid'  => 'info',
                        'on-site' => 'warning',
                        default   => 'gray',
                    })
                    ->formatStateUsing(fn($state) => ucfirst($state)),

                Tables\Columns\TextColumn::make('tags.name')
                    ->label('Tags')
                    ->badge()
                    ->color('gray')
                    ->separator(',')
                    ->placeholder('—')
                    ->wrap(),

                Tables\Columns\TextColumn::make('applications_count')
                    ->label('Apps')
                    ->counts('applications')
                    ->sortable()
                    ->alignCenter()
                    ->color('info'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Posted')
                    ->since()
                    ->sortable()
                    ->color('gray')
            ])->actions([
                Tables\Actions\ViewAction::make()
                    ->infolist([
                        Infolists\Components\Section::make('Job Details')
                            ->columns(3)
                            ->schema([
                                Infolists\Components\TextEntry::make('title'),
                                Infolists\Components\TextEntry::make('company_name')->label('Company'),
                                Infolists\Components\TextEntry::make('location')->placeholder('—'),
                                Infolists\Components\TextEntry::make('type')
                                    ->badge()
                                    ->color(fn($state) => match ($state) {
                                        'remote'  => 'success',
                                        'hybrid'  => 'info',
                                        'on-site' => 'warning',
                                        default   => 'gray',
                                    }),
                                Infolists\Components\TextEntry::make('salary_range')->label('Salary')->placeholder('—'),
                                Infolists\Components\TextEntry::make('expires_at')->label('Expires')->date('M j, Y')->placeholder('Never'),
                            ]),
                        Infolists\Components\Section::make('Content')
                            ->schema([
                                Infolists\Components\TextEntry::make('description')->prose()->columnSpanFull(),
                                Infolists\Components\TextEntry::make('requirements')->prose()->columnSpanFull()->placeholder('—'),
                            ]),
                        Infolists\Components\Section::make('Tags')
                            ->schema([
                                Infolists\Components\TextEntry::make('tags.name')
                                    ->label('')
                                    ->badge()
                                    ->separator(',')
                                    ->placeholder('No tags'),
                            ]),
                    ]),

                Tables\Actions\EditAction::make()
                    ->form([
                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\TextInput::make('title')->required()->columnSpan(2),
                            Forms\Components\TextInput::make('company_name')->label('Company')->required(),
                            Forms\Components\TextInput::make('location'),
                            Forms\Components\Select::make('type')
                                ->options([
                                    'remote'  => 'Remote',
                                    'hybrid'  => 'Hybrid',
                                    'on-site' => 'On-site',
                                ])
                                ->native(false),
                            Forms\Components\TextInput::make('salary_range')->label('Salary'),
                            Forms\Components\DateTimePicker::make('expires_at')->label('Expiry date')->native(false)->columnSpan(2),
                            Forms\Components\Textarea::make('description')->rows(4)->columnSpan(2),
                            Forms\Components\Textarea::make('requirements')->rows(4)->columnSpan(2),
                        ]),
                    ]),

                Tables\Actions\DeleteAction::make(),
            ])
            ->defaultSort('created_at', 'desc')
            ->paginationPageOptions([3, 5, 10, 25, 50])
            ->emptyStateIcon('heroicon-o-briefcase')
            ->emptyStateHeading('No job listings')
            ->emptyStateDescription('Job posts will appear here once employers start hiring.');
    }

    public function render()
    {
        return view('livewire.admin.job-listings');
    }
}
