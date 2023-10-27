<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {

       \DB::statement($this->createView());

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        \DB::statement($this->dropView());
        
    }

    private function createView(): string
    {
        return <<<SQL
            CREATE VIEW controlUser AS
                SELECT u.id AS id,u.name AS name,u.email AS email,i.id AS iId,i.name AS iName,t.id AS tId,t.surname AS tSurname,t.name AS tName,t.patronymic AS tPatronymic, mRole.max_role FROM users u
                LEFT JOIN institutions i ON i.idModerator = u.id
                LEFT JOIN teachers t ON t.idUser = u.id
                LEFT JOIN (
                    SELECT mr.model_id, MAX(mr.role_id) as max_role FROM model_has_roles mr GROUP BY mr.model_id
                    ) mRole ON mRole.model_id = u.id

            SQL;
    }

    private function dropView(): string
    {
        return <<<SQL

            DROP VIEW IF EXISTS `controlUser`;
            SQL;
    }
};

