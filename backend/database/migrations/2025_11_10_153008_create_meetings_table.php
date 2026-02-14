<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trek_id')->constrained()->onUpdate('restrict')->onDelete('restrict');
            $table->date('dateIni');
            $table->date('dateEnd')->nullable();
            $table->foreignId('user_id')->constrained()->onUpdate('restrict')->onDelete('restrict');
            $table->integer('totalScore')->default(0);
            $table->integer('countScore')->default(0);
            $table->decimal('rating', 5, 2)->default(0);
            $table->date('day');
            $table->time('hour');
            //$table->foreignId('guide_id')->constrained('users'); --- CHECK LATER ---
            $table->timestamps();
        });

        DB::statement('
                CREATE TRIGGER update_ratings_after_insert_meetings
                AFTER INSERT ON meetings
                FOR EACH ROW
                BEGIN
                    DECLARE v_status CHAR(1);
                    DECLARE v_totalScore INT DEFAULT 0;
                    DECLARE v_countScore INT DEFAULT 0;
                    DECLARE v_rating DECIMAL(10,2) DEFAULT 0;

                    -- Obtener el status del trek asociado
                    SELECT status INTO v_status
                    FROM treks
                    WHERE id = NEW.trek_id;

                    -- Calcular suma de ratings y número de meetings del trek
                    SELECT IFNULL(SUM(rating),0), COUNT(*)
                    INTO v_totalScore, v_countScore
                    FROM meetings
                    WHERE trek_id = NEW.trek_id;

                    -- Calcular media
                    IF v_countScore > 0 THEN
                        SET v_rating = v_totalScore / v_countScore;
                    ELSE
                        SET v_rating = 0;
                    END IF;

                    -- Actualizar treks solo si está activo
                    IF (v_status = "y") AND v_countScore > 0 THEN
                        UPDATE treks
                        SET totalRating = v_totalScore,
                            countRating = v_countScore,
                            rating = v_rating
                        WHERE id = NEW.trek_id;
                    END IF;
                END
        ');

        DB::statement('
            CREATE TRIGGER trg_meetings_au_update_treks_rating
        AFTER UPDATE ON meetings
        FOR EACH ROW
        BEGIN
            DECLARE v_status CHAR(1);
            DECLARE v_totalScore DECIMAL(10,2) DEFAULT 0;
            DECLARE v_countScore INT DEFAULT 0;
            DECLARE v_rating DECIMAL(10,2) DEFAULT 0;

            -- Obtener el status del trek asociado
            SELECT status INTO v_status
            FROM treks
            WHERE id = NEW.trek_id;

            -- Calcular suma de ratings y número de meetings del trek
            SELECT IFNULL(SUM(rating),0), COUNT(*)
            INTO v_totalScore, v_countScore
            FROM meetings
            WHERE trek_id = NEW.trek_id;

            -- Calcular media
            IF v_countScore > 0 THEN
                SET v_rating = v_totalScore / v_countScore;
            ELSE
                SET v_rating = 0;
            END IF;

            -- Actualizar treks solo si está activo
            IF (v_status = "y") AND v_countScore > 0 THEN
                UPDATE treks
                SET totalRating = v_totalScore,
                    countRating = v_countScore,
                    rating = v_rating
                WHERE id = NEW.trek_id;
            END IF;
        END;

        ');

        DB::statement('
            CREATE TRIGGER trg_meetings_ad_update_treks_rating
        AFTER DELETE ON meetings
        FOR EACH ROW
        BEGIN
            DECLARE v_status CHAR(1);
            DECLARE v_totalScore DECIMAL(10,2) DEFAULT 0;
            DECLARE v_countScore INT DEFAULT 0;
            DECLARE v_rating DECIMAL(10,2) DEFAULT 0;

            -- Obtener el status del trek asociado
            SELECT status INTO v_status
            FROM treks
            WHERE id = OLD.trek_id;

            -- Calcular suma de ratings y número de meetings del trek
            SELECT IFNULL(SUM(rating),0), COUNT(*)
            INTO v_totalScore, v_countScore
            FROM meetings
            WHERE trek_id = OLD.trek_id;

            -- Calcular media
            IF v_countScore > 0 THEN
                SET v_rating = v_totalScore / v_countScore;
            ELSE
                SET v_rating = 0;
            END IF;

            -- Actualizar treks solo si está activo
            IF (v_status = "y") THEN
                UPDATE treks
                SET totalRating = v_totalScore,
                    countRating = v_countScore,
                    rating = v_rating
                WHERE id = OLD.trek_id;
            END IF;
        END;
        ');
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meetings');
    }
};
