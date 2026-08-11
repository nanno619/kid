<?php

namespace App\DataTransferObjects;

use App\Http\Requests\StoreStaffProfileRequest;

final readonly class AddressData
{
    public function __construct(
        public string $addressLine1,
        public ?string $addressLine2,
        public ?string $addressLine3,
        public ?int $stateId,
        public ?string $district,
        public ?string $city,
        public ?string $postcode,
    ) {}

    public static function fromRequest(StoreStaffProfileRequest $request): self
    {
        $address = $request->validated('address');

        return new self(
            addressLine1: $address['address_line_1'],
            addressLine2: $address['address_line_2'] ?? null,
            addressLine3: $address['address_line_3'] ?? null,
            stateId: $address['state_id'] ?? null,
            district: $address['district'] ?? null,
            city: $address['city'] ?? null,
            postcode: $address['postcode'] ?? null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'address_line_1' => $this->addressLine1,
            'address_line_2' => $this->addressLine2,
            'address_line_3' => $this->addressLine3,
            'state_id' => $this->stateId,
            'district' => $this->district,
            'city' => $this->city,
            'postcode' => $this->postcode,
        ];
    }
}
