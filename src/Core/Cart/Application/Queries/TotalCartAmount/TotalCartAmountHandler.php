<?php

namespace Cart\Core\Cart\Application\Queries\TotalCartAmount;

use Cart\Core\Cart\Domain\Dtos\CartMoneyDto;
use Cart\Core\Cart\Domain\Repositories\CartRepositoryContract;
use Cart\Core\Cart\Domain\Services\CurrencyExchangeProviderContract;
use Cart\Core\Product\Domain\Repositories\ProductRepositoryContract;
use Cart\Shared\Domain\Contracts\Bus\QueryBus\QueryHandlerContract;
use Cart\Shared\Domain\ValueObjects\Money\Currency;


class TotalCartAmountHandler implements QueryHandlerContract
{
    private CartRepositoryContract $cartRepository;
    private ProductRepositoryContract $productRepository;
    private CurrencyExchangeProviderContract $currencyExchanger;

    /**
     * @param CurrencyExchangeProviderContract $currencyExchanger
     * @param CartRepositoryContract $cartRepository
     * @param ProductRepositoryContract $productRepository
     */
    public function __construct(CurrencyExchangeProviderContract $currencyExchanger, CartRepositoryContract $cartRepository, ProductRepositoryContract $productRepository)
    {
        $this->cartRepository = $cartRepository;
        $this->productRepository = $productRepository;
        $this->currencyExchanger = $currencyExchanger;
    }


    /**
     * Always calculates the original currency. If the query has it, we convert the amount in other currency
     * @param TotalCartAmountQuery $query
     * @return TotalCartAmountResult
     */
    public function handle(TotalCartAmountQuery $query): TotalCartAmountResult
    {
        $cart = $this->cartRepository->openByUserOrFail($query->userId);

        $cartAmount = $cart->calculateTotalAmount($this->productRepository, $query->withDiscounts);

        //If is queried, converted the amount with other currency
        if(null !== $query->currency && $query->currency->notEquals(Currency::fromDefault())){
            $convertedAmount = $this->currencyExchanger->exchangeTo($cartAmount->amount, $query->currency);

            $convertedAmount = new CartMoneyDto(
                $convertedAmount->getAmountValue(),
                $convertedAmount->currency->getValue()
            );
        }

        $originalAmount = new CartMoneyDto(
            $cartAmount->getAmountValue(),
            $cartAmount->currency->getValue()
        );

        return new TotalCartAmountResult($originalAmount, $convertedAmount ?? null);
    }
}
