<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Models\Commande;
use App\Models\Produit;

class ValiderCommande extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $errors = [];
        $successCount = 0;

        foreach ($models as $commande) {
            // Charger les relations avec les produits
            $commande->load('produits');
            
            // Vérifier que la commande n'est pas déjà validée
            if ($commande->statut === 'Validée') {
                $errors[] = "La commande #{$commande->id} est déjà validée.";
                continue;
            }

            // Vérifier que la commande n'est pas déjà livrée
            if ($commande->statut === 'Livrée') {
                $errors[] = "La commande #{$commande->id} est déjà livrée.";
                continue;
            }

            // Vérifier le stock pour tous les produits de la commande
            $stockErrors = [];
            foreach ($commande->produits as $produit) {
                $quantiteCommande = $produit->pivot->quantite;
                $stockDisponible = $produit->stock;

                if ($stockDisponible < $quantiteCommande) {
                    $stockErrors[] = "Produit '{$produit->nom}': Stock insuffisant (demandé: {$quantiteCommande}, disponible: {$stockDisponible})";
                }
            }

            if (!empty($stockErrors)) {
                $errors[] = "Commande #{$commande->id}: " . implode(', ', $stockErrors);
                continue;
            }

            // Décrémenter le stock pour tous les produits
            foreach ($commande->produits as $produit) {
                $quantiteCommande = $produit->pivot->quantite;
                $produit->decrement('stock', $quantiteCommande);
            }

            // Mettre à jour le statut de la commande
            $commande->update(['statut' => 'Validée']);
            $successCount++;
        }

        if ($successCount > 0) {
            return Action::message("{$successCount} commande(s) validée(s) avec succès. Stock mis à jour.");
        }

        if (!empty($errors)) {
            return Action::danger(implode("\n", $errors));
        }

        return Action::message('Aucune commande traitée.');
    }

    /**
     * Get the fields available on the action.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [];
    }

    /**
     * The displayable name of the action.
     *
     * @var string
     */
    public $name = 'Valider la commande';

    /**
     * Indicates if this action is only available on the resource index view.
     *
     * @var bool
     */
    public $onlyOnIndex = false;

    /**
     * Indicates if this action is only available on the resource detail view.
     *
     * @var bool
     */
    public $onlyOnDetail = true;
}
