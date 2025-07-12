<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Http\Requests\NovaRequest;

class Produit extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Produit>
     */
    public static $model = \App\Models\Produit::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'nom';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'nom', 'description',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @return array<int, \Laravel\Nova\Fields\Field>
     */
    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()->sortable(),
            Text::make('Nom', 'nom')
                ->sortable()
                ->rules('required', 'max:255'),
            
            Textarea::make('Description', 'description')
                ->rules('required'),
            
            Number::make('Prix', 'prix')
                ->sortable()
                ->rules('required', 'numeric', 'min:0'),
            
            Number::make('Stock', 'stock')
                ->sortable()
                ->rules('required', 'integer', 'min:0')
                ->help('Quantité en stock'),
            
            Number::make('Seuil d\'alerte', 'seuil_alerte')
                ->rules('nullable', 'integer', 'min:0')
                ->help('Seuil pour déclencher une alerte de stock faible')
                ->default(5),
            
            BelongsTo::make('Catégorie', 'categorie', Category::class)
                ->sortable()
                ->nullable(),
            
            Image::make('Image', 'image_url')
                ->disk('public')
                ->path('produits')
                ->nullable(),
            
            BelongsToMany::make('Commandes')
                ->fields(function () {
                    return [
                        Number::make('Quantite', 'quantite')
                            ->rules('required', 'integer', 'min:1'),
                        Number::make('Prix unitaire', 'prix_unitaire')
                            ->rules('required', 'numeric', 'min:0')
                            ->step(0.01),
                    ];
                }),
        ];
    }

    /**
     * Get the cards available for the resource.
     *
     * @return array<int, \Laravel\Nova\Card>
     */
    public function cards(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array<int, \Laravel\Nova\Filters\Filter>
     */
    public function filters(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @return array<int, \Laravel\Nova\Lenses\Lens>
     */
    public function lenses(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @return array<int, \Laravel\Nova\Actions\Action>
     */
    public function actions(NovaRequest $request): array
    {
        return [];
    }
}
