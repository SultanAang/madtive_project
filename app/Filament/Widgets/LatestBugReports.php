<?php

namespace App\Filament\Widgets;

use App\Models\BugReport;
use Filament\Facades\Filament;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Support\Enums\TextSize;
// --- Imports Khusus Filament v5 Infolists ---
use Filament\Actions\ViewAction; // Pastikan namespace ini benar
use Filament\Infolists\Infolist;
// use Filament\Infolists\Components\Section;
// use Filament\Infolists\Components\Grid;
use Filament\Schemas\Components\Grid;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Support\Enums\FontWeight;
use Filament\Schemas\Components\Section;

class LatestBugReports extends BaseWidget {
    protected int|string|array $columnSpan = "full";
    protected static ?int $sort = 2;

    public function table(Table $table): Table {
        return $table
            ->query(BugReport::query()->where("project_id", Filament::getTenant()->id))
            ->defaultSort("created_at", "desc")
            ->columns([
                Tables\Columns\TextColumn::make("title")->label("Judul")->limit(30)->searchable(),
                Tables\Columns\TextColumn::make("user.name")
                    ->label("Pelapor")
                    ->icon("heroicon-m-user"),
                Tables\Columns\TextColumn::make("priority")->badge()->color(
                    fn(string $state) => match ($state) {
                        "low" => "info",
                        "medium" => "warning",
                        "high" => "orange",
                        "critical" => "danger",
                        default => "gray", // Fallback aman
                    },
                ),
                Tables\Columns\TextColumn::make("status")
                    ->badge()
                    // Tambahkan logika warna untuk status juga agar konsisten
                    ->color(
                        fn(string $state) => match ($state) {
                            "resolved" => "success",
                            "process" => "primary",
                            "rejected" => "danger",
                            default => "gray", // Pending / Lainnya
                        },
                    ),
                Tables\Columns\TextColumn::make("created_at")->label("Waktu")->dateTime(),
            ])
            ->actions([
                ViewAction::make()->label("Detail")->modalHeading("Detail Laporan Bug")->infolist(
                    fn($infolist) => $infolist->schema([
                        // 1. Section Informasi Dasar
                        Section::make("Informasi Dasar")
                            ->icon("heroicon-m-information-circle")
                            ->schema([
                                Grid::make(2)->schema([
                                    TextEntry::make("title")
                                        ->label("Judul Masalah")
                                        ->columnSpanFull()
                                        ->weight(FontWeight::Bold)
                                        ->size(TextSize::Large),

                                    TextEntry::make("user.name")
                                        ->label("Dilaporkan Oleh")
                                        ->icon("heroicon-m-user"),

                                    TextEntry::make("priority")->label("Prioritas")->badge()->color(
                                        fn(string $state) => match ($state) {
                                            "low" => "info",
                                            "medium" => "warning",
                                            "high" => "orange",
                                            "critical" => "danger",
                                            default => "gray",
                                        },
                                    ),

                                    TextEntry::make("created_at")->label("Waktu Lapor")->dateTime(),
                                ]),
                            ]),

                        // 2. Section Kronologi
                        Section::make("Kronologi & Deskripsi")
                            ->icon("heroicon-m-document-text")
                            ->schema([
                                TextEntry::make("description")->hiddenLabel()->prose()->markdown(),
                            ]),

                        // 3. Section Bukti Gambar
                        Section::make("Bukti Screenshot")
                            ->icon("heroicon-m-photo")
                            ->schema([
                                ImageEntry::make("screenshot_path")
                                    ->hiddenLabel()
                                    ->height(400)
                                    // ->extraImgAttributes([
                                    //     "class" =>
                                    //         "-lg shadow-md border border-gray-200 object-contain w-full",
                                    //     rounded"loading" => "lazy",
                                    // ])
                                    ->checkFileExistence(true)
                                    // ->image() // Menampilkan sebagai gambar
                                    ->disk("public") // <--- TAMBAHKAN INI (Penting!)
                                    ->visibility("public")
                                    // ->imagePreviewHeight("400")
                                    ->disabled() // Pastikan tidak bisa diedit
                                    // ->dehydrated(false) // Jangan kirim data saat save
                                    ->columnSpanFull(),
                            ]),
                        // Gunakan BugReport $record agar IDE tidak bingung
                        // ->hidden(fn(BugReport $record) => $record->screenshot_path === null),
                    ]),
                ),
            ]);
    }
}
