<?php

use yii\db\Schema;
use yii\db\Migration;

class m170116_131148_create_tables extends Migration
{
    public function up()
    {   
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        //пользователи
        $this->createTable('{{%user}}', [
            'id'                   => $this->primaryKey(),
            'name'                 => $this->string()->notNull(),
            'auth_key'             => $this->string(32)->notNull(),
            'password_hash'        => $this->string()->notNull(),
            'password_reset_token' => $this->string(),
            'email'                => $this->string()->notNull(),
            'created_at'           => $this->integer(),
            'updated_at'           => $this->integer(),
        ], $tableOptions);

        $this->batchInsert('{{%user}}', ['name', 'auth_key', 'password_hash', 'email'], [
            ['admin', 'PQJs7c6MpUDYfS-G0f99QX2njAc9Xedo', '$2y$13$DUU.GS6KCwMyJPLSmhqci.z1Vyt06bb78db1is47GZnYDogqipwCW', 'admin@admin.admin'],
            ['user', 'PQJs7c6MpUDYfS-G0f99QX2njAc9Xedo', '$2y$13$DUU.GS6KCwMyJPLSmhqci.z1Vyt06bb78db1is47GZnYDogqipwCW', 'user@user.user'],
        ]);

        //ингредиенты
        $this->createTable('{{%ingredient}}', [
            'id'          => $this->primaryKey(),
            'title'       => $this->string()->notNull(),
            'description' => $this->text(),
            'is_active'   => $this->smallInteger()->notNull()->defaultValue(1),
        ], $tableOptions);

        $this->batchInsert('{{%ingredient}}', ['title', 'description'], [
            ['Маслята', 'Маслёнок – род трубчатых грибов семейства Болетовые. Своё название получил из-за маслянистой, 
            скользкой на ощупь шляпки. Характерными признаками, отличающими большинство видов маслят от других болетовых, 
            является клейкая слизистая, легко снимающаяся кожица шляпки и кольцо, оставшееся от частного покрывала.'],
            ['Бекон', 'Бекон – малосольная или копчёная свинина особого приготовления.'],
            ['Говядина', 'Говядина является мясом крупного рогатого скота.'],
            ['Бобы', 'Бобы – термин, как правило, обозначающий плоды либо семена любой зернобобовой культуры, 
            а также растений семейства Бобовые в целом.'],
            ['Кабачок', 'Кабачком принято называть травяной однолетник семейства Тыквенные, ближайший родственник обыкновенной тыквы.'],
        ], $tableOptions);

        //блюда
        $this->createTable('{{%dish}}', [
            'id'          => $this->primaryKey(),
            'title'       => $this->string()->notNull(),
            'description' => $this->text(),
        ], $tableOptions);

        //связь блюд и ингредиентов
        $this->createTable('{{%dish_to_ingredient}}', [
            'dish_id'       => $this->integer()->notNull(),
            'ingredient_id' => $this->integer()->notNull(),
        ]);

        $this->addPrimaryKey('', '{{%dish_to_ingredient}}', ['dish_id', 'ingredient_id']);

        $this->addForeignKey('dish_to_ingredient_dish_id', '{{%dish_to_ingredient}}', 'dish_id', 'dish', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('dish_to_ingredient_ingredient_id', '{{%dish_to_ingredient}}', 'ingredient_id', 'ingredient', 'id', 'CASCADE', 'CASCADE');

    }

    public function down()
    {
        $this->dropForeignKey('dish_to_ingredient_dish_id', '{{%dish_to_ingredient}}');
        $this->dropForeignKey('dish_to_ingredient_ingredient_id', '{{%dish_to_ingredient}}');

        $this->dropTable('{{%dish_to_ingredient}}');
        $this->dropTable('{{%dish}}');
        $this->dropTable('{{%ingredient}}');
        $this->dropTable('{{%user}}');
    }
}
