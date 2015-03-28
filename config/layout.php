<?php

return [
    'element' => [ // Base layout elements
        'template' => [
            'model' => 'Theme\Element\Type\Template',
            'output_model' => [
                'html' => 'Theme\Element\Output\Html\Template',
            ],
        ],
        'text' => [
            'model' => 'Theme\Element\Type\Text',
            'output_model' => [
                'html' => 'Theme\Element\Output\Html\Text',
            ],
        ],
        'document_head' => [
            'model' => 'Theme\Element\Type\Document\Head',
            'output_model' => [
                'html' => 'Theme\Element\Output\Html\Document\Head',
                'json' => 'Layout\Element\Output\Json\JsonIgnore'
            ],
        ],
    ],
];
