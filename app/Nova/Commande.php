<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Nova\Actions\ValiderCommande;
use App\Nova\Actions\LivrerCommande;

class Commande extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Commande>
     */
    public static $model = \App\Models\Commande::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'statut',
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
            
            BelongsTo::make('Client', 'client')
                ->sortable()
                ->rules('required')
                ->showOnIndex()
                ->showOnDetail(),
            
            DateTime::make('Date de commande', 'date_commande')
                ->sortable()
                ->rules('required')
                ->default(now())
                ->showOnIndex()
                ->showOnDetail(),
            
            Select::make('Statut', 'statut')
                ->options([
                    'En attente' => 'En attente',
                    'Validée' => 'Validée',
                    'Livrée' => 'Livrée',
                ])
                ->sortable()
                ->rules('required')
                ->showOnIndex()
                ->showOnDetail(),
            
            // Affichage des produits dans la liste
            Text::make('Produits', function () {
                if (!$this->produits) return 'Aucun produit';
                
                $produits = [];
                foreach ($this->produits as $produit) {
                    $produits[] = "{$produit->nom} (Qte: {$produit->pivot->quantite}, Prix: {$produit->pivot->prix_unitaire}€)";
                }
                return implode(', ', $produits);
            })
            ->showOnIndex()
            ->hideFromDetail(),
            
            // Détails complets des produits dans la vue détaillée
            BelongsToMany::make('Produits')
                ->fields(function () {
                    return [
                        Number::make('Quantite', 'quantite')
                            ->rules('required', 'integer', 'min:1'),
                        Number::make('Prix unitaire', 'prix_unitaire')
                            ->rules('required', 'numeric', 'min:0')
                            ->step(0.01),
                    ];
                })
                ->hideFromIndex()
                ->showOnDetail(),
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
        return [
            ValiderCommande::make(),
            LivrerCommande::make(),
        ];
    }
}
