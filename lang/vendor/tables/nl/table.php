<?php

return [

    'fields' => [

        'search_query' => [
            'label' => 'Zoeken',
            'placeholder' => 'Zoeken',
        ],

    ],

    'pagination' => [

        'label' => 'Paginering navigatie',

        'overview' => 'Toont :first tot :last van :total resultaten',

        'fields' => [

            'records_per_page' => [
                'label' => 'per pagina',
            ],

        ],

        'buttons' => [

            'go_to_page' => [
                'label' => 'Ga naar pagina :page',
            ],

            'next' => [
                'label' => 'Volgende',
            ],

            'previous' => [
                'label' => 'Vorige',
            ],

        ],

    ],

    'buttons' => [

        'filter' => [
            'label' => 'Filteren',
        ],

        'open_actions' => [
            'label' => 'Acties openen',
        ],

        'toggle_columns' => [
            'label' => 'Kolommen in-/uitschakelen',
        ],

    ],

    'empty' => [
        'heading' => 'Geen resultaten gevonden',
    ],

    'filters' => [

        'buttons' => [

            'reset' => [
                'label' => 'Filters resetten',
            ],

            'close' => [
                'label' => 'Sluiten',
            ],

        ],

        'multi_select' => [
            'placeholder' => 'Alles',
        ],

        'select' => [
            'placeholder' => 'Alles',
        ],

        'trashed' => [

            'label' => 'Verwijderde records',

            'only_trashed' => 'Alleen verwijderde records',

            'with_trashed' => 'Met verwijderde records records',

            'without_trashed' => 'Zonder verwijderde records',

        ],

    ],

    'selection_indicator' => [

        'selected_count' => '1 record geselecteerd.|:count records geselecteerd.',


        'buttons' => [

            'select_all' => [
                'label' => 'Selecteer alle :count',
            ],

            'deselect_all' => [
                'label' => 'Alles deselecteren',
            ],

        ],

    ],

];
