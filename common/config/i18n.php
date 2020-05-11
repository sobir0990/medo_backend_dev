<?php

return [
    'sourcePath' => __DIR__ . DIRECTORY_SEPARATOR . '..',
    'languages' => ['ru', 'uz', 'oz'],
    'translator' => 'Yii::t',
    // boolean, whether to sort messages by keys when merging new messages
    // with the existing ones. Defaults to false, which means the new (untranslated)
    // messages will be separated from the old (translated) ones.
    'sort' => false,
    'removeUnused' => false,
    // boolean, whether to mark messages that no longer appear in the source code.
    // Defaults to true, which means each of these messages will be enclosed with a pair of '@@' marks.
    'markUnused' => true,
    // array, list of patterns that specify which files (not directories) should be processed.
    // If empty or not set, all files will be processed.
    // See helpers/FileHelper::findFiles() for pattern matching rules.
    // If a file/directory matches both a pattern in "only" and "except", it will NOT be processed.
    'only' => ['*.php'],
    // array, list of patterns that specify which files/directories should NOT be processed.
    // If empty or not set, all files/directories will be processed.
    // See helpers/FileHelper::findFiles() for pattern matching rules.
    // If a file/directory matches both a pattern in "only" and "except", it will NOT be processed.
    'except' => [
        '.svn',
        '.git',
        '.gitignore',
        '.gitkeep',
        '.hgignore',
        '.hgkeep',
        '/messages',
    ],

    // Root directory containing message translations.
    'messagePath' => __DIR__,
    // boolean, whether the message file should be overwritten with the merged messages
    'overwrite' => true,
    /*
    // File header used in generated messages files
    'phpFileHeader' => '',
    // PHPDoc used for array of messages with generated messages files
    'phpDocBlock' => null,
    */

    'ignoreCategories' => [
        'yii',
    ],
    'format' => 'db',
    // Connection component to use. Optional.
    'db' => 'db',

    /*
    // 'po' output format is for saving messages to gettext po files.
    'format' => 'po',
    // Root directory containing message translations.
    'messagePath' => __DIR__ . DIRECTORY_SEPARATOR . 'messages',
    // Name of the file that will be used for translations.
    'catalog' => 'messages',
    // boolean, whether the message file should be overwritten with the merged messages
    'overwrite' => true,
    */
];
