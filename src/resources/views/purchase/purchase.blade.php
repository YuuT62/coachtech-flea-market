@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('header')
    @component('components.header')
    @endcomponent
@endsection

@section('content')

<div class="purchase-wrapper">
    <div class="purchase-item">
        <div class="purchase-item-info">
            <div class="purchase-item-info__img">
                <img  src="{{ asset($item->item_img) }}" alt="item_img">
            </div>
            <div class="purchase-item-info__data">
                <h1 class="purchase-item-info__data-name">{{ $item->item_name }}</h1>
                <p class="purchase-item-info__data-price">¥{{ number_format($item->price) }}</p>
            </div>
        </div>
        <table class="purchase-item-table">
            <tr class="purchase-item-row">
                <th class="purchase-item-header">支払い方法</th>
                <td class="purchase-item-desc">
                    <button class="button js-modal-button" type='button'>変更する</button>
                </td>
            </tr>
        </table>
        <div class="layer js-modal">
            <div class="modal">
                <div class="modal__inner">
                <!-- ×ボタン追記 -->
                <div class="modal__button-wrap">
                <button class="close-button js-close-button" type='button'>
                    <span></span>
                    <span></span>
                </button>
                </div>
                <div class="modal__contents">
                    <div class="modal__content">
                        <label for="credit"><input type="radio" name="pay_method" value="0" id="credit" checked onchange="inputChange()">クレジットカード払い</label>
                        <label for="convenience"><input type="radio" name="pay_method" value="1" id="convenience" onchange="inputChange()">コンビニ払い</label>
                        <label for="bank"><input type="radio" name="pay_method" value="2" id="bank" onchange="inputChange()">銀行振込</label>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <table class="purchase-item-table">
            <tr class="purchase-item-row">
                <th class="purchase-item-header">配送先</th>
                <td class="purchase-item-desc"><a href="/purchase/address/{{ $item->id }}">変更する</a></td>
            </tr>
            @if(session('address_id') != null)
            <tr class="purchase-item-row">
                <th class="purchase-item-header">郵便番号</th>
                <td class="purchase-item-desc">{{ session('postcode') }}</td>
            </tr>
            <tr class="purchase-item-row">
                <th class="purchase-item-header">住所</th>
                <td class="purchase-item-desc">{{ session('address') }}</td>
            </tr>
            <tr class="purchase-item-row">
                <th class="purchase-item-header">建物名</th>
                <td class="purchase-item-desc">{{ session('building') }}</td>
            </tr>
            @else
                @isset($register_address)
                <tr class="purchase-item-row">
                    <th class="purchase-item-header">郵便番号</th>
                    <td class="purchase-item-desc">{{ $register_address->postcode }}</td>
                </tr>
                <tr class="purchase-item-row">
                    <th class="purchase-item-header">住所</th>
                    <td class="purchase-item-desc">{{ $register_address->prefecture. $register_address->city. $register_address->block }}</td>
                </tr>
                <tr class="purchase-item-row">
                    <th class="purchase-item-header">建物名</th>
                    <td class="purchase-item-desc">{{ $register_address->building }}</td>
                </tr>
                @endif
            @endif
        </table>
    </div>
    <div class="purchase-form">
        <table class="purchase-form-table">
            <tr class="purchase-form-row">
                <th class="purchase-form-header" style="padding-bottom:50px">商品代金</th>
                <td class="purchase-form-desc" style="padding-bottom:50px">¥{{ number_format($item->price) }}</td>
            </tr>
            <tr class="purchase-form-row">
                <th class="purchase-form-header" >支払い金額</th>
                <td class="purchase-form-desc">¥{{ number_format($item->price) }}</td>
            </tr>
            <tr class="purchase-form-row">
                <th class="purchase-form-header">支払い方法</th>
                <td class="purchase-form-desc" id="pay_method_view">クレジットカード払い</td>
            </tr>
        </table>
        <div class="purchase-form-btn">
            @if(isset($register_address) == false && session('address_id') == null)
            <button class="purchase-form-btn__submit" style="background-color:#C0C0C0; border:3px solid #C0C0C0; pointer-events:none;">配送先を指定してください</button>
            @else
            <button class="purchase-form-btn__submit" id="checkout-button">購入する</button>
            @endif
        </div>
    </div>
</div>

<script>
const modal = document.querySelector('.js-modal');
const modalButton = document.querySelector('.js-modal-button');

const modalClose = document.querySelector('.js-close-button');

modalButton.addEventListener('click', () => {
    modal.classList.add('is-open');
});

// 追記
modalClose.addEventListener('click', () => {
    modal.classList.remove('is-open');
});


function inputChange(){
    let pay_method_view = document.getElementById('pay_method_view');
    let value = document.getElementsByName('pay_method');
        for(var i=0; i<value.length; i++) {
            if(value[0].checked) {
                pay_method_view.innerText = "クレジットカード払い";
            }else if(value[1].checked){
                pay_method_view.innerText = "コンビニ払い";
            }else{
                pay_method_view.innerText = "銀行振込";
            }
        }
    }
</script>

<?php //現在のURL取得関数
function nowUrl($item_id){
    $url = '';
    if(isset($_SERVER['HTTPS'])){
        $url .= 'https://';
    }else{
        $url .= 'http://';
    }
    $url .= $_SERVER['HTTP_HOST'] . str_replace($item_id, '',str_replace('?', '', $_SERVER['REQUEST_URI']));
    return $url;
}
?>

<script src="https://js.stripe.com/v3/"></script>
<!-- 決済選択・stripe Checkout処理 -->
<script type="text/javascript">
    <?php
    $secretKey = env('STRIPE_SECRET');
    $publicKey = env('STRIPE_KEY');
    $stripe = new \Stripe\StripeClient($secretKey);
    $address_id = "";
    $item_id = $item->id;

    if(session('address_id') != null){
        $address_id = session('address_id');
    }else if(isset($register_address)){
        $address_id = $register_address->id;
    }
    ?>

    const checkoutButton = document.getElementById('checkout-button');
    let value = document.getElementsByName('pay_method');
    checkoutButton.addEventListener('click', function() {
        if (value[0].checked) {
            <?php
            $session_credit = $stripe->checkout->sessions->create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'JPY',
                        'product_data' => [
                            'name' => $item->item_name,
                        ],
                        'unit_amount' => $item->price,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => nowUrl($item_id). 'success/submit/{CHECKOUT_SESSION_ID}/'. $item_id. '/'. $address_id. '/1',
                'cancel_url' => nowUrl($item_id). 'cancel/submit',
            ]);
            ?>

            var stripe = Stripe('<?php echo $publicKey;?>');
            stripe.redirectToCheckout({sessionId: "<?php echo $session_credit->id;?>"});
        }else if(value[1].checked){
            <?php
            $session_convenience = $stripe->checkout->sessions->create([
                'payment_method_types' => ['konbini'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'JPY',
                        'product_data' => [
                            'name' => $item->item_name,
                        ],
                        'unit_amount' => $item->price,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => nowUrl($item_id). 'success/submit/{CHECKOUT_SESSION_ID}/'. $item_id. '/'. $address_id. '/2',
                'cancel_url' => nowUrl($item_id). 'cancel/submit',
            ]);
            ?>
            var stripe = Stripe('<?php echo $publicKey;?>');
            stripe.redirectToCheckout({sessionId: "<?php echo $session_convenience->id;?>"});
        }else{
            <?php
            $customer = $stripe->customers->create();
            $session_bank = $stripe->checkout->sessions->create([
                'customer' => $customer->id,
                'payment_method_types' => ['customer_balance'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'JPY',
                        'product_data' => [
                            'name' => $item->item_name,
                        ],
                        'unit_amount' => $item->price,
                    ],
                    'quantity' => 1,
                ]],
                'payment_method_options' => [
                    'customer_balance' => [
                        'funding_type' => 'bank_transfer',
                        'bank_transfer' => [
                            'type' => 'jp_bank_transfer',
                        ]
                    ]
                ],
                'mode' => 'payment',
                'success_url' => nowUrl($item_id). 'success/submit/{CHECKOUT_SESSION_ID}/'. $item_id. '/'. $address_id. '/3',
                'cancel_url' => nowUrl($item_id). 'cancel/submit',
            ]);
            ?>
            var stripe = Stripe('<?php echo $publicKey;?>');
            stripe.redirectToCheckout({sessionId: "<?php echo $session_bank->id;?>"});
        }
    });
</script>
@endsection