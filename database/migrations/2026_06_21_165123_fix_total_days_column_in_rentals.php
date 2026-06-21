use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::statement('ALTER TABLE rentals MODIFY total_days INT NOT NULL');
    }

    public function down(): void
    {
        //
    }
};