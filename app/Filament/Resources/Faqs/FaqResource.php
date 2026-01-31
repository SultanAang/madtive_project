<?php

// [PENTING] Namespace ini menyesuaikan dengan folder tempat file Anda berada (Faqs)
namespace App\Filament\Resources\Faqs;

use App\Filament\Resources\Faqs\Pages;
use App\Models\Faq;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
// use Filament\Actions\Action;
// use Filament\Actions\BulkActionGroup;
// use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
// use Filament\Tables\Actions\EditAction;
use Filament\Tables\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;

// [PENTING] Gunakan Schema untuk Filament v5
use Filament\Schemas\Schema;
use BackedEnum;
use UnitEnum;
class FaqResource extends Resource {
    protected static ?string $model = Faq::class;

    // TAMBAHKAN INI: Agar menu hilang dari sidebar
    // public static function shouldRegisterNavigation(): bool {
    //     return false;
    // }

    // [PENTING] Kita hapus 'type hint' (?string) di depan variabel ini
    // agar tidak error (crash) di PHP 8.4 yang Anda gunakan.
    protected static string|BackedEnum|null $navigationIcon = "heroicon-o-question-mark-circle";
    protected static string|UnitEnum|null $navigationGroup = "Content";

    protected static ?string $tenantOwnershipRelationshipName = 'project';

    // [FIX v5] Gunakan Schema $schema
    public static function form(Schema $schema): Schema {
        return $schema->components([
            Forms\Components\TextInput::make("question")
                ->label("Pertanyaan")
                ->required()
                ->columnSpanFull(),

            Forms\Components\RichEditor::make("answer")
                ->label("Jawaban")
                ->required()
                ->columnSpanFull(),

            Forms\Components\TextInput::make("category")
                ->label("Kategori")
                ->placeholder("Contoh: Umum, Teknis"),

            Forms\Components\Toggle::make("is_visible")->label("Tampilkan?")->default(true),
        ]);
    }

    // [FIX Table] Gunakan Table standar
    public static function table(Table $table): Table {
        return $table
            ->columns([
                TextColumn::make("question")->limit(50)->searchable(),

                TextColumn::make("category")->badge(), // Menampilkan kategori seperti lencana/label warna

                ToggleColumn::make("is_visible")->label("Aktif"),
            ])
            ->actions([EditAction::make(), DeleteBulkAction::make()]);
        // TIPS: Jika di Filament v5 'actions' tidak muncul,
        // coba ganti menjadi ->recordActions([ ... ]) sesuai snippet dokumentasi.
    }

    public static function getRelations(): array {
        return [];
    }

    public static function getPages(): array {
        return [
            "index" => Pages\ListFaqs::route("/"),
            "create" => Pages\CreateFaq::route("/create"),
            "edit" => Pages\EditFaq::route("/{record}/edit"),
        ];
    }
}
