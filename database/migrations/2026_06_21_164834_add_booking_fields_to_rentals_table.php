use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

public function up(): void
{
    Schema::table('rentals', function (Blueprint $table) {
        $table->string('ktp_file')->nullable();
        $table->string('sim_file')->nullable();
        $table->boolean('airport_pickup')->default(false);
        $table->boolean('with_driver')->default(false);
        $table->boolean('keyless')->default(false);
        $table->decimal('addon_fees', 12, 2)->default(0);
        $table->integer('total_days')->default(0);
        $table->string('pickup_location')->nullable();
    });
}

public function down(): void
{
    Schema::table('rentals', function (Blueprint $table) {
        $table->dropColumn([
            'ktp_file',
            'sim_file',
            'airport_pickup',
            'with_driver',
            'keyless',
            'addon_fees',
            'total_days',
            'pickup_location',
        ]);
    });
}