<?php

use yii\db\Migration;

/**
 * Handles the creation of table 'settings'.
 */
class m181016_060232_create_settings_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%settings}}', [
            '[[setting_id]]' => $this->primaryKey(),
            '[[title]]' => $this->string(255),
            '[[description]]' => $this->text(),
            '[[slug]]' => $this->string(255),
            '[[type]]' => $this->integer(11),
            '[[input]]' => $this->integer(11),
            '[[data]]' => $this->text(),
            '[[default]]' => $this->string(255),
            '[[sort]]' => $this->integer(),
            '[[lang_hash]]' => $this->string(255),
            '[[lang]]' => $this->integer(),
        ]);

        $this->batchInsert('settings', ['setting_id', 'title', 'description', 'slug', 'type', 'input', 'data', 'default', 'sort', 'lang_hash', 'lang'], [
            [1, 'Текст на футере', '', 'text-on-the-footer', 3, 5, NULL, '', NULL, 'myM_fy9DWEJaMALrbtDTczbUC8sEssd5J72OUpswdZEbJSmEji', 1],
            [2, 'Текст на футере', '', 'text-on-the-footer', 3, 5, NULL, '', NULL, 'myM_fy9DWEJaMALrbtDTczbUC8sEssd5J72OUpswdZEbJSmEji', 2],
            [3, 'Текст на футере', '', 'text-on-the-footer', 3, 5, NULL, '', NULL, 'myM_fy9DWEJaMALrbtDTczbUC8sEssd5J72OUpswdZEbJSmEji', 3],
            [58, 'Текст на футере', '', 'text-on-the-footer', 3, 5, NULL, '', NULL, 'myM_fy9DWEJaMALrbtDTczbUC8sEssd5J72OUpswdZEbJSmEji', 4],
            [4, 'текст Шапки', '', 'text-head', 2, 5, NULL, '', NULL, 'sbb5_rnobY3yOa_hlDjqSz0miKKrmHICySfBgGdTC1Tq1AMFmx', 1],
            [5, 'текст Шапки', '', 'text-head', 2, 5, NULL, '', NULL, 'sbb5_rnobY3yOa_hlDjqSz0miKKrmHICySfBgGdTC1Tq1AMFmx', 2],
            [6, 'текст Шапки', '', 'text-head', 2, 5, NULL, '', NULL, 'sbb5_rnobY3yOa_hlDjqSz0miKKrmHICySfBgGdTC1Tq1AMFmx', 3],
            [59, 'текст Шапки', '', 'text-head', 2, 5, NULL, '', NULL, 'sbb5_rnobY3yOa_hlDjqSz0miKKrmHICySfBgGdTC1Tq1AMFmx', 4],
            [7, 'Тел номер', '', 'phone-number', 1, 1, NULL, '', NULL, 'cjIIbYzVQhX1mv_00vYo-_Zc9hM7d95wDP-NYGo8rAoyxXQXFE', 1],
            [8, 'Тел номер', '', 'phone-number', 1, 1, NULL, '', NULL, 'cjIIbYzVQhX1mv_00vYo-_Zc9hM7d95wDP-NYGo8rAoyxXQXFE', 2],
            [9, 'Тел номер', '', 'phone-number', 1, 1, NULL, '', NULL, 'cjIIbYzVQhX1mv_00vYo-_Zc9hM7d95wDP-NYGo8rAoyxXQXFE', 3],
            [60, 'Тел номер', '', 'phone-number', 1, 1, NULL, '', NULL, 'cjIIbYzVQhX1mv_00vYo-_Zc9hM7d95wDP-NYGo8rAoyxXQXFE', 4],
            [10, 'Тел номер 2', '', 'phone-number2', 1, 1, NULL, '', NULL, '3oHaLuGEzgYLqGWZcd2_9Nhd-VFPVD85hd8AYYoMjNskmXeFRx', 1],
            [11, 'Тел номер 2', '', 'phone-number2', 1, 1, NULL, '', NULL, '3oHaLuGEzgYLqGWZcd2_9Nhd-VFPVD85hd8AYYoMjNskmXeFRx', 2],
            [12, 'Тел номер 2', '', 'phone-number2', 1, 1, NULL, '', NULL, '3oHaLuGEzgYLqGWZcd2_9Nhd-VFPVD85hd8AYYoMjNskmXeFRx', 3],
            [61, 'Тел номер 2', '', 'phone-number2', 1, 1, NULL, '', NULL, '3oHaLuGEzgYLqGWZcd2_9Nhd-VFPVD85hd8AYYoMjNskmXeFRx', 4],
            [13, 'Факс', '', 'fax', 1, 1, NULL, '', NULL, '3oHaLuGEzgYLqGWZcd2_9Nhd-VFPVD85hd8AYYoMjNskmXeFRx', 1],
            [14, 'Факс', '', 'fax', 1, 1, NULL, '', NULL, '3oHaLuGEzgYLqGWZcd2_9Nhd-VFPVD85hd8AYYoMjNskmXeFRx', 2],
            [15, 'Факс', '', 'fax', 1, 1, NULL, '', NULL, '3oHaLuGEzgYLqGWZcd2_9Nhd-VFPVD85hd8AYYoMjNskmXeFRx', 3],
            [62, 'Факс', '', 'fax', 1, 1, NULL, '', NULL, '3oHaLuGEzgYLqGWZcd2_9Nhd-VFPVD85hd8AYYoMjNskmXeFRx', 4],
            [16, 'Телеграм', '', 'telegram', 4, 1, NULL, '', NULL, '23Exh3-gyS6Ss2AqCslmKdzYodUmdrs3Y6T1JFk0cZhc4mImO8', 1],
            [17, 'Телеграм', '', 'telegram', 4, 1, NULL, '', NULL, '23Exh3-gyS6Ss2AqCslmKdzYodUmdrs3Y6T1JFk0cZhc4mImO8', 2],
            [18, 'Телеграм', '', 'telegram', 4, 1, NULL, '', NULL, '23Exh3-gyS6Ss2AqCslmKdzYodUmdrs3Y6T1JFk0cZhc4mImO8', 3],
            [63, 'Телеграм', '', 'telegram', 4, 1, NULL, '', NULL, '23Exh3-gyS6Ss2AqCslmKdzYodUmdrs3Y6T1JFk0cZhc4mImO8', 4],
            [19, 'Электронная почта', '', 'email', 1, 1, NULL, '', NULL, '9SChFap9a39-dsTLe6EaMqLt2di4owvDxisfwrsJ91julM9rgm', 1],
            [20, 'Электронная почта', '', 'email', 1, 1, NULL, '', NULL, '9SChFap9a39-dsTLe6EaMqLt2di4owvDxisfwrsJ91julM9rgm', 2],
            [21, 'Электронная почта', '', 'email', 1, 1, NULL, '', NULL, '9SChFap9a39-dsTLe6EaMqLt2di4owvDxisfwrsJ91julM9rgm', 3],
            [64, 'Электронная почта', '', 'email', 1, 1, NULL, '', NULL, '9SChFap9a39-dsTLe6EaMqLt2di4owvDxisfwrsJ91julM9rgm', 4],
            [22, 'Адрес', '', 'adress', 1, 5, NULL, '', NULL, '8oQdhE1C2-wZpDVrKYiPH8aFQev1EwV7mnUgBj_VEXgkcQ_hrS', 1],
            [23, 'Адрес', '', 'adress', 1, 5, NULL, '', NULL, '8oQdhE1C2-wZpDVrKYiPH8aFQev1EwV7mnUgBj_VEXgkcQ_hrS', 2],
            [24, 'Адрес', '', 'adress', 1, 5, NULL, '', NULL, '8oQdhE1C2-wZpDVrKYiPH8aFQev1EwV7mnUgBj_VEXgkcQ_hrS', 3],
            [65, 'Адрес', '', 'adress', 1, 5, NULL, '', NULL, '8oQdhE1C2-wZpDVrKYiPH8aFQev1EwV7mnUgBj_VEXgkcQ_hrS', 4],
            [25, 'Карта', '', 'map', 1, 5, NULL, '', NULL, 'T_Jf7zhkjWgOaNHLM-VUBcRtBg9a1lqKSt3AsxFZLt7R9Ej48m', 1],
            [26, 'Карта', '', 'map', 1, 5, NULL, '', NULL, 'T_Jf7zhkjWgOaNHLM-VUBcRtBg9a1lqKSt3AsxFZLt7R9Ej48m', 2],
            [27, 'Карта', '', 'map', 1, 5, NULL, '', NULL, 'T_Jf7zhkjWgOaNHLM-VUBcRtBg9a1lqKSt3AsxFZLt7R9Ej48m', 3],
            [66, 'Карта', '', 'map', 1, 5, NULL, '', NULL, 'T_Jf7zhkjWgOaNHLM-VUBcRtBg9a1lqKSt3AsxFZLt7R9Ej48m', 4],
            [28, 'Keywords', '', 'keywords', 1, 1, NULL, '', NULL, 'A3zCJVsS9COz2_QPMYHVqLqLEZfBtGX8cWLgGg11_f-hzX3he3', 1],
            [29, 'Keywords', '', 'keywords', 1, 1, NULL, '', NULL, 'A3zCJVsS9COz2_QPMYHVqLqLEZfBtGX8cWLgGg11_f-hzX3he3', 2],
            [30, 'Keywords', '', 'keywords', 1, 1, NULL, '', NULL, 'A3zCJVsS9COz2_QPMYHVqLqLEZfBtGX8cWLgGg11_f-hzX3he3', 3],
            [67, 'Keywords', '', 'keywords', 1, 1, NULL, '', NULL, 'A3zCJVsS9COz2_QPMYHVqLqLEZfBtGX8cWLgGg11_f-hzX3he3', 4],
            [31, 'og-image', '', 'og-image', 1, 1, NULL, '', NULL, 'u7-qaDluAR_8EW1yqaW_n1AM7OLeFeajYC4jA1_UA0okpPdQMf', 1],
            [32, 'og-image', '', 'og-image', 1, 1, NULL, '', NULL, 'u7-qaDluAR_8EW1yqaW_n1AM7OLeFeajYC4jA1_UA0okpPdQMf', 2],
            [33, 'og-image', '', 'og-image', 1, 1, NULL, '', NULL, 'u7-qaDluAR_8EW1yqaW_n1AM7OLeFeajYC4jA1_UA0okpPdQMf', 3],
            [68, 'og-image', '', 'og-image', 1, 1, NULL, '', NULL, 'u7-qaDluAR_8EW1yqaW_n1AM7OLeFeajYC4jA1_UA0okpPdQMf', 4],
            [34, 'og-title', '', 'og-title', 1, 1, NULL, '', NULL, 'qQ8iaa_8nP_XTPbUWYkUKzk7bPY10SlwgsOcifcVsI7Y2-aEwG', 1],
            [35, 'og-title', '', 'og-title', 1, 1, NULL, '', NULL, 'qQ8iaa_8nP_XTPbUWYkUKzk7bPY10SlwgsOcifcVsI7Y2-aEwG', 2],
            [36, 'og-title', '', 'og-title', 1, 1, NULL, '', NULL, 'qQ8iaa_8nP_XTPbUWYkUKzk7bPY10SlwgsOcifcVsI7Y2-aEwG', 3],
            [69, 'og-title', '', 'og-title', 1, 1, NULL, '', NULL, 'qQ8iaa_8nP_XTPbUWYkUKzk7bPY10SlwgsOcifcVsI7Y2-aEwG', 4],
            [37, 'telegram-social', '', 'telegram-social', 4, 1, NULL, '', NULL, '0rK9p4TDfzLWCcm9O2nx_X_d0-UXiVUr81KUxHt4yoN6diHFJu', 1],
            [38, 'telegram-social', '', 'telegram-social', 4, 1, NULL, '', NULL, '0rK9p4TDfzLWCcm9O2nx_X_d0-UXiVUr81KUxHt4yoN6diHFJu', 2],
            [39, 'telegram-social', '', 'telegram-social', 4, 1, NULL, '', NULL, '0rK9p4TDfzLWCcm9O2nx_X_d0-UXiVUr81KUxHt4yoN6diHFJu', 3],
            [70, 'telegram-social', '', 'telegram-social', 4, 1, NULL, '', NULL, '0rK9p4TDfzLWCcm9O2nx_X_d0-UXiVUr81KUxHt4yoN6diHFJu', 4],
            [40, 'facebook-social', '', 'facebook-social', 4, 1, NULL, '', NULL, 'y90qlfNbNJIoRmgPLs-XJfJTJVks3IpKD_tbHxDZXwdj73ZQMx', 1],
            [41, 'facebook-social', '', 'facebook-social', 4, 1, NULL, '', NULL, 'y90qlfNbNJIoRmgPLs-XJfJTJVks3IpKD_tbHxDZXwdj73ZQMx', 2],
            [42, 'facebook-social', '', 'facebook-social', 4, 1, NULL, '', NULL, 'y90qlfNbNJIoRmgPLs-XJfJTJVks3IpKD_tbHxDZXwdj73ZQMx', 3],
            [71, 'facebook-social', '', 'facebook-social', 4, 1, NULL, '', NULL, 'y90qlfNbNJIoRmgPLs-XJfJTJVks3IpKD_tbHxDZXwdj73ZQMx', 4],
            [43, 'twitter-social', '', 'twitter-social', 4, 1, NULL, '', NULL, 'EBc1pV5zy-woObDmthKkeQO2Htyl5EoM1B_bHYhJ3bdtewpav7', 1],
            [44, 'twitter-social', '', 'twitter-social', 4, 1, NULL, '', NULL, 'EBc1pV5zy-woObDmthKkeQO2Htyl5EoM1B_bHYhJ3bdtewpav7', 2],
            [45, 'twitter-social', '', 'twitter-social', 4, 1, NULL, '', NULL, 'EBc1pV5zy-woObDmthKkeQO2Htyl5EoM1B_bHYhJ3bdtewpav7', 3],
            [72, 'twitter-social', '', 'twitter-social', 4, 1, NULL, '', NULL, 'EBc1pV5zy-woObDmthKkeQO2Htyl5EoM1B_bHYhJ3bdtewpav7', 4],
            [46, 'instagram', '', 'instagram', 4, 1, NULL, '', NULL, 'L43ADWSAbpDEKFt3uSaILzANMzLxDaA0udFAHlLLHknJOotkZW', 1],
            [47, 'instagram', '', 'instagram', 4, 1, NULL, '', NULL, 'L43ADWSAbpDEKFt3uSaILzANMzLxDaA0udFAHlLLHknJOotkZW', 2],
            [48, 'instagram', '', 'instagram', 4, 1, NULL, '', NULL, 'L43ADWSAbpDEKFt3uSaILzANMzLxDaA0udFAHlLLHknJOotkZW', 3],
            [73, 'instagram', '', 'instagram', 4, 1, NULL, '', NULL, 'L43ADWSAbpDEKFt3uSaILzANMzLxDaA0udFAHlLLHknJOotkZW', 4],
            [49, 'Logo', '', 'logo', 2, 6, NULL, '', NULL, 'L43ADWSAbpDEKFt4uSaILzANMzLxDaA0udFAHlLLHknJOotkZW', 1],
            [50, 'Logo', '', 'logo', 2, 6, NULL, '', NULL, 'L43ADWSAbpDEKFt4uSaILzANMzLxDaA0udFAHlLLHknJOotkZW', 2],
            [51, 'Logo', '', 'logo', 2, 6, NULL, '', NULL, 'L43ADWSAbpDEKFt4uSaILzANMzLxDaA0udFAHlLLHknJOotkZW', 3],
            [74, 'Logo', '', 'logo', 2, 6, NULL, '', NULL, 'L43ADWSAbpDEKFt4uSaILzANMzLxDaA0udFAHlLLHknJOotkZW', 4],
            [52, 'Default Photo', '', 'default_photo', 1, 6, NULL, '', NULL, 'L43ADwSAbpDEKFt4uSaILzANMzLxDaA0udFAHlLLHknJOotkZW', 1],
            [53, 'Default Photo', '', 'default_photo', 1, 6, NULL, '', NULL, 'L43ADwSAbpDEKFt4uSaILzANMzLxDaA0udFAHlLLHknJOotkZW', 2],
            [54, 'Default Photo', '', 'default_photo', 1, 6, NULL, '', NULL, 'L43ADwSAbpDEKFt4uSaILzANMzLxDaA0udFAHlLLHknJOotkZW', 3],
            [75, 'Default Photo', '', 'default_photo', 1, 6, NULL, '', NULL, 'L43ADwSAbpDEKFt4uSaILzANMzLxDaA0udFAHlLLHknJOotkZW', 4],
            [55, 'google-plus', '', 'google-plus', 4, 1, NULL, '', NULL, 'EBC1pV5zy-woObDmthKkeQO2Htyl5EoM1B_bHYhJ3bdtewpav7', 1],
            [56, 'google-plus', '', 'google-plus', 4, 1, NULL, '', NULL, 'EBC1pV5zy-woObDmthKkeQO2Htyl5EoM1B_bHYhJ3bdtewpav7', 2],
            [57, 'google-plus', '', 'google-plus', 4, 1, NULL, '', NULL, 'EBC1pV5zy-woObDmthKkeQO2Htyl5EoM1B_bHYhJ3bdtewpav7', 3],
            [76, 'google-plus', '', 'google-plus', 4, 1, NULL, '', NULL, 'EBC1pV5zy-woObDmthKkeQO2Htyl5EoM1B_bHYhJ3bdtewpav7', 4],
        ]);
        /*
         * Создание индекса для создание отношение:
         * Языка - langs
         */
        $this->createIndex(
            'idx-settings-langs-lang',
            '{{%settings}}',
            '[[lang]]'
        );
        //Создание отношение
        $this->addForeignKey(
            'fk-settings-langs-lang',
            '{{%settings}}',
            '[[lang]]',
            '{{%langs}}',
            '[[lang_id]]',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-settings-langs-lang',
            '{{%settings}}'
        );

        $this->dropIndex(
            'idx-settings-langs-lang',
            '{{%settings}}'
        );

        $this->dropTable('{{%settings}}');
    }
}
