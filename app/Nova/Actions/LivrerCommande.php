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

class LivrerCommande extends Action
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
            // Vérifier que la commande est validée
            if ($commande->statut !== 'Validée') {
                $errors[] = "La commande #{$commande->id} doit être validée avant d'être livrée.";
                continue;
            }

            // Vérifier que la commande n'est pas déjà livrée
            if ($commande->statut === 'Livrée') {
                $errors[] = "La commande #{$commande->id} est déjà livrée.";
                continue;
            }

            // Mettre à jour le statut de la commande
            $commande->update(['statut' => 'Livrée']);
            $successCount++;
        }

        if ($successCount > 0) {
            return Action::message("{$successCount} commande(s) marquée(s) comme livrée(s).");
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
    public $name = 'Marquer comme livrée';

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
