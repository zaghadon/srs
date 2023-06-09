@extends('layouts.app');

@section('title', 'Withdraw Funds from your Wallet')

@section('content')

    <div class="buysell wide-xs m-auto">
        @include('components.deposit-withdraw-nav')
        <div class="buysell-title text-center">
            <h2 class="title">Withdraw From Your Wallet!</h2>
        </div><!-- .buysell-title -->
        <div class="buysell-block">
            <div class="text-danger">
                <x-jet-validation-errors class="mb-4" />
            </div>
            <form action="{{ route('withdraw.store') }}" method="POST" name="withdraw" class="buysell-form">
                @csrf
                <div class="buysell-field form-group">
                    <div class="form-label-group">
                        <label class="form-label" for="buysell-amount">Amount to Withdraw</label>
                    </div>
                    <div class="form-control-group">
                        <input type="number" step=".01" class="form-control form-control-lg form-control-number"
                            id="buysell-amount" name="amount" placeholder="1000.00" required>
                        <div class="form-dropdown">
                            <div class="text-primary">NGN</div>
                        </div>
                    </div>
                    <div class="form-note-group">
                        <span class="buysell-min form-note-alt">Minimum: 1000.00 NGN</span>
                        <span class="buysell-rate form-note-alt">1 NGN = 1 NGN (SRS)</span>
                    </div>
                </div><!-- .buysell-field -->
                <div class="buysell-field form-group">
                    <div class="form-label-group">
                        <label class="form-label">Payment Method</label>
                    </div>
                    <div class="form-pm-group">
                        <ul class="buysell-pm-list">
                            {{-- <li class="buysell-pm-item">
                            <input class="buysell-pm-control" type="radio" name="bs-method" id="pm-paypal" />
                            <label class="buysell-pm-label" for="pm-paypal">
                                <span class="pm-name">Paystack</span>
                                <span class="pm-icon"><em class="icon ni ni-paypal-alt"></em></span>
                            </label>
                        </li> --}}
                            <li class="buysell-pm-item">
                                <input class="buysell-pm-control" type="radio" value="mtnmomo" name="method"
                                    id="pm-bank" required />
                                <label class="buysell-pm-label" for="pm-bank">
                                    <span class="pm-name">MTN MOMO</span>
                                    <span class="pm-icon"><em class="icon ni ni-building-fill"></em></span>
                                </label>
                            </li>
                            <li class="buysell-pm-item">
                                <input class="buysell-pm-control" type="radio" value="bank" name="method"
                                    id="pm-card" required />
                                <label class="buysell-pm-label" for="pm-card">
                                    <span class="pm-name">Direct to Bank</span>
                                    <span class="pm-icon"><em class="icon ni ni-cc-alt-fill"></em></span>
                                </label>
                            </li>
                        </ul>
                    </div>
                </div><!-- .buysell-field -->

                <div id="direct-bank" style="display: none;">
                    <div class="buysell-field form-group">
                        <div class="form-label-group">
                            <label class="form-label">Choose choose bank to withdraw to:</label>
                        </div>
                        <input type="hidden" value="000" name="bank" id="buysell-choose-currency">
                        <div class="dropdown buysell-cc-dropdown">
                            <a href="#" class="buysell-cc-choosen dropdown-indicator" data-bs-toggle="dropdown">
                                <div class="coin-item coin-000">
                                    <div class="coin-icon">
                                        <em class="icon ni ni-building-fill"></em>
                                    </div>
                                    <div class="coin-info">
                                        <span class="coin-name">Select Bank</span>
                                        <span class="coin-text">Nigerian banks, and CBN Code</span>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-auto dropdown-menu-mxh">
                                <ul class="buysell-cc-list">
                                    <li class="buysell-cc-item selected">
                                        <a href="#" class="buysell-cc-opt" data-currency="000">
                                            <div class="coin-item coin-000">
                                                <div class="coin-icon">
                                                    <em class="icon ni ni-building-fill"></em>
                                                </div>
                                                <div class="coin-info">
                                                    <span class="coin-name">Select Bank</span>
                                                    <span class="coin-text">Nigerian banks, and CBN Code</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    @forelse (getAllNigerianBanks() as $bank)
                                        <li class="buysell-cc-item">
                                            <a href="#" class="buysell-cc-opt" data-value="{{ $bank->code }}"
                                                data-currency="{{ $bank->code }}">
                                                <div class="coin-item coin-{{ $bank->code }}">
                                                    <div class="coin-icon">
                                                        <em class="icon ni ni-building-fill"></em>
                                                    </div>
                                                    <div class="coin-info">
                                                        <span class="coin-name">{{ $bank->name }}</span>
                                                        <span class="coin-text">{{ $bank->code }}</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                    @empty
                                        <li class="buysell-cc-item">
                                            <a href="#" class="buysell-cc-opt" data-currency="eth">
                                                <div class="coin-item coin-eth">
                                                    <div class="coin-icon">
                                                        <em class="icon ni ni-covid"></em>
                                                    </div>
                                                    <div class="coin-info">
                                                        <span class="coin-name">No Banks Fetched</span>
                                                        <span class="coin-text">Check You Internet Connection and Refresh
                                                            Page</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                    @endforelse
                                </ul>
                            </div><!-- .dropdown-menu -->
                        </div><!-- .dropdown -->
                    </div><!-- .buysell-field -->

                    <div class="buysell-field form-group">
                        <div class="form-label-group">
                            <label class="form-label" for="buysell-amount">Account</label>
                        </div>
                        <div class="form-control-group">
                            <input type="number" class="form-control form-control-lg form-control-number"
                                id="buysell-account" name="account_number" placeholder="5113077322">
                            <div class="form-dropdown">
                                <div class="text-primary">NUBAN</div>
                            </div>
                        </div>
                        <div class="form-note-group">
                            <span id="account-name" class="buysell-min form-note-alt">Account Name:</span>
                        </div>
                    </div><!-- .buysell-field -->
                </div>


                <div class="buysell-field form-action">
                    <button class="btn btn-lg btn-block btn-primary" type="submit">Continue to
                        Withdraw</button>
                </div><!-- .buysell-field -->
                <div class="form-note text-base text-center">NB: transfer fees may be included at checkout, <a
                        href="#">Learn about fees</a>.</div>
            </form><!-- .buysell-form -->
        </div><!-- .buysell-block -->
    </div><!-- .buysell -->

@endsection
{{-- @include('components.modals.withdraw-modal') --}}

@push('scripts')
    <script>
        $(document).ready(function() {
            // Event handler for selecting an option
            $('.buysell-pm-item').click(function() {
                payment_method = document.forms["withdraw"]["method"].value;

                switch (payment_method) {
                    case 'bank':
                        $('#direct-bank').css('display', 'block');
                        break;

                    default:
                        $('#direct-bank').css('display', 'none');
                        break;
                }
            });
        });

        function handlePay(event) {
            event.preventDefault(); // Prevent the form from submitting

            payment_method = document.forms["deposit"]["method"].value;

            switch (payment_method) {
                case 'card':
                    makeCardPayment();
                    break;

                default:

                    break;
            }
        }
    </script>
    <script>
        $(document).ready(function() {
            // Event handler for selecting an option
            $('.buysell-cc-opt').click(function(e) {
                e.preventDefault();

                // Get the selected option's data-currency and data-value values
                var selectedCurrency = $(this).data('currency');
                var selectedValue = $(this).data('value');

                // Update the hidden input value and data-value attribute
                $('#buysell-choose-currency').val(selectedCurrency).attr('data-value', selectedValue);

                // Update the displayed selected option
                var selectedOption = $(this).html();
                $('.buysell-cc-choosen').html(selectedOption);

                // Remove the "selected" class from all options
                $('.buysell-cc-item').removeClass('selected');

                // Add the "selected" class to the clicked option
                $(this).closest('.buysell-cc-item').addClass('selected');
            });

            $("#buysell-account").on("input", function() {
                let bankCode = $("#buysell-choose-currency").val();
                let accountNumber = $("#buysell-account").val();

                if (bankCode.length > 0 && accountNumber.length === 10) {
                    // Make a request to Flutterwave's API

                    var settings = {
                        url: "https://api.flutterwave.com/v3/accounts/resolve",
                        method: "POST",
                        timeout: 0,
                        crossDomain: true,
                        headers: {
                            "Content-Type": "application/json",
                            "Authorization": "Bearer " + "<?php echo env('FLW_PRV_KEY'); ?>"
                        },
                        data: JSON.stringify({
                            "account_number": accountNumber,
                            "account_bank": bankCode
                        }),
                        xhrFields: {
                            withCredentials: true
                        }
                    };

                    $.ajax(settings).done(function(response) {
                        console.log(response);
                        let accountName = response.data.account_name;
                        $("#account-name").text(`Account Name: ${accountName}`);
                    }).fail(function(jqXHR, textStatus) {
                        console.error(textStatus);
                        $("#account-name").text("Error occurred while verifying the account.");
                    });
                }
            });
        });
    </script>
@endpush

@push('styles')
@endpush
