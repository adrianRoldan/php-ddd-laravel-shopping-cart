<?php

namespace Apps\Api\Cart\TotalAmount;

use Apps\Shared\Http\Response\ResourceContract;
use Cart\Core\Cart\Application\Queries\TotalCartAmount\TotalCartAmountResult;

final class TotalCartAmountResource implements ResourceContract
{
    public TotalCartAmountResult $totalWithDiscounts;
    public TotalCartAmountResult $totalWithoutDiscounts;

    public function __construct(TotalCartAmountResult $totalWithDiscounts, TotalCartAmountResult $totalWithoutDiscounts)
    {
        $this->totalWithDiscounts = $totalWithDiscounts;
        $this->totalWithoutDiscounts = $totalWithoutDiscounts;
    }

    public function toArray(): array
    {
        $result["withoutDiscount"] = [
                $this->totalWithoutDiscounts->originalCurrency->currency => ["price" => $this->totalWithoutDiscounts->originalCurrency->price]
        ];

        if($this->totalWithoutDiscounts->convertedCurrency){
            $result["withoutDiscount"] = array_merge($result["withoutDiscount"], [
                $this->totalWithoutDiscounts->convertedCurrency->currency => ["price" => $this->totalWithoutDiscounts->convertedCurrency->price]
            ]);
        }

        $result["withDiscount"] = [
            $this->totalWithDiscounts->originalCurrency->currency => ["price" => $this->totalWithDiscounts->originalCurrency->price]
        ];

        if($this->totalWithDiscounts->convertedCurrency){
            $result["withDiscount"] = array_merge($result["withDiscount"], [
                $this->totalWithDiscounts->convertedCurrency->currency => ["price" => $this->totalWithDiscounts->convertedCurrency->price]
            ]);
        }

        return $result;
    }
}
