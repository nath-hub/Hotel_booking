<?php

namespace App\Services;

use App\Models\Bedroom;
use App\Models\User;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\UploadedFile;

class BedroomService
{


    /**
     * list a bedroom
     * 
     * @param User $user the Director who list a bedroom
     * @param array $input The bedroom data
     * 
     * @return array The list data of the bedroom
     */
    public function index(User $user, array $input): Paginator
    {

        $hotelId = $user->people->hotel_id;

        $input['hotel_id'] = $hotelId;

        return Bedroom::with('showerRoom')
            ->filter($input)
            ->orderBy('code')
            ->paginate(10)
            ->withQueryString()
            ->through(fn ($bedroom) => [
                'id' => $bedroom->id,
                'code' => $bedroom->code,
                'bed_number' => $bedroom->bed_number,
                'price' => $bedroom->price,
                'type' => $bedroom->showerRoom->type,
                'created_at' => $bedroom->created_at?->format('Y-m-d')
            ]);
    }

    /**
     * Create a bedroom
     * 
     * @param User $user the Director who create a bedroom
     * @param array $input The bedroom data
     * 
     * @return array The newly created data of the bedroom
     */
    public function store(User $user, array $input): array
    {

        $input['hotel_id'] = $user->people->hotel_id;

        $input = collect($input);

        $bedroomData = $input->only(['code', 'bed_number', 'price', 'images', 'hotel_id'])->all();
        $showerRoomData = $input->only(['type', 'imagesShower'])->all();

        $bedroom = Bedroom::create($bedroomData);

        $showerRoom = $bedroom->showerRoom()->create($showerRoomData);

        return [
            'shower_room' => $showerRoom,
            'bedroom' => $bedroom
        ];
    }


        /**
     * Upload user avatar
     * 
     * @param UploadedFile $avatarFile The avatar file
     * 
     * @return array
     */
    public function uploadFileBedroom(UploadedFile $imageBedroom, UploadedFile $imageShower): array
    {

        $bedroomPath = $imageBedroom->store('bedroom/images', 'public');
        $showerPath = $imageShower->store('showerRoom/images', 'public');

        return [
            'shower_path' => $showerPath,
            'shower_url' => asset($showerPath),
            'bedroom_path' => $bedroomPath,
            'bedroom_url' => asset($bedroomPath),
        ];
    }


    /**
     * show a bedroom
     * 
     * @param User $user the Director who show a bedroom
     * @param array $input The bedroom data
     * 
     * @return array The data of the bedroom
     */
    public function show(Bedroom $bedroom)
    {

        return [
            'shower_room' => $bedroom->showerRoom,
            'bedroom' => $bedroom->getAttributes()
        ];
    }

    public function update(Bedroom $bedroomToUpdate, array $input)
    {


        $input = collect($input);

        $bedroomData = $input->only(['code', 'bed_number', 'price', 'hotel_id'])->all();
        $showerRoomData = $input->only(['type'])->all();

        $bedroomToUpdate->update($bedroomData);

        $bedroomToUpdate->showerRoom()->update($showerRoomData);

        return [
            "code" => 204
        ];
    }
}
