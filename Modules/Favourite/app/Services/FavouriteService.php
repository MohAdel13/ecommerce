<?php
namespace Modules\Favourite\Services;

use App\Utils\DTO;
use Modules\Favourite\Repositories\FavouriteRepository;

class FavouriteService
{
    public function __construct(private FavouriteRepository $favouriteRepository)
    {
    }

    public function modify(DTO $dataObject)
    {
        $favourite = $this->favouriteRepository->findUserFavourite($dataObject->user, $dataObject->product_id);

        if ($favourite) {
            $this->favouriteRepository->removeFromFavourite($dataObject->user, $dataObject->product_id);
        } else {
            $this->favouriteRepository->addToFavourite($dataObject->user, $dataObject->product_id);
        }
    }
}