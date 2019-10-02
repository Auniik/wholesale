    $(document).on('click', '.patient_type', function () {
        patientFilter()
    });

    $(window).load( function () {
        patientFilter()
    })

    $(document).on('keyup', '#patient_name, .service-names', function () {
        if (!$('.patient_type:checked').val()) {
            alert('Select Patient Type');
        }

    });


    function  loadPatient(event, ui) {

        $('#patient_id_no').val(ui.item.data.patient_id).attr('readonly', true);
        $('#patient_age').val(ui.item.data.age).attr('readonly', true);
        $('#mobile_no').val(ui.item.data.mobile_number).attr('readonly', true);
        $('#disease').val(ui.item.data.disease).attr('readonly', true);
        $('#patient_id').val(ui.item.data.id).attr('readonly', true);

        $('[name=sex][value='+ui.item.data.sex+']').attr('checked', true);
        $('[name=blood][value='+ui.item.data.blood+']').attr('selected', true);
    }
    function resetPatient(){
        // $('#patient_name').val('');
        $('#discount').val(0).attr('readonly', false);
        $('#patient_id_no').val('').attr('readonly', true);
        $('#patient_age').val('').attr('readonly', false);
        $('#mobile_no').val('').attr('readonly', false);
        $('#disease').val('').attr('readonly', false);
        $('#patient_id').val('').attr('readonly', false);

        $('#commission_for_agent').prop('checked', false)
    }


    function discountCalculator(totalAmount, discount)
    {
        if (!discount){
            discount = 0;
        }

        let amount = totalAmount - totalAmount * discount/100
        $('#payable_amount').val(amount);

        if ($('#paid').val() > amount){
            $('#payable_amount').val(amount);
            $('#discount').val(discount);
            $('#paid').val(amount);
            alert('You cant pay more than payable amount!');
        }
    }

    function cardFilter(discountType)
    {
        cardReset();
        loadDetails({
            type: 'cardNumber',
            selector: '#card-number',
            url: requestUrl({path: 'load-card-holder'}),
            select: function (event, ui) {
                $(this.selector).removeClass('has-error').attr('title', '');
                let cardBasedDiscount = 0;
                if (discountType == "indoor"){
                    cardBasedDiscount = ui.item.data.card_type.indoor_discount;
                }
                if (discountType == "outdoor") {
                    cardBasedDiscount = ui.item.data.card_type.outdoor_discount;
                }
                $('#discount').val(cardBasedDiscount).attr('readonly', true);
                $('#card_id').val(ui.item.data.card_type.id);

                // loadPatient(event, ui)
                $('#patient_name').val('').attr('readonly', false);
                $('#patient_id').val('');
                loadDetails({
                    type: 'nameWithNumber',
                    selector: '#patient_name',
                    url: requestUrl({
                        path: 'loadPatient?card_number=',
                        param: ui.item.data.card_number
                    }),
                select: function (event, ui) {
                    loadPatient(event, ui)
                    $(this.selector).removeClass('has-error').attr('title', '');
                },
                    search:function (event) {
                        // resetPatient();
                        $(this.selector).addClass('has-error').prop('title', 'Not Recognized');
                    }
            })
        },
            search: function () {
                resetPatient();
                $(this.selector).addClass('has-error').prop('title', 'Not Recognized');
            }
        })
    }

    function selfFilter()
    {
        selfReset()

        loadDetails({
            type: 'name',
            selector: '#reference-by',
            url: requestUrl({
                path: 'load-commission-refers'
            }),
            select: function (event, ui) {
                $('#reference_id').val(ui.item.data.id);
            },
            search: function () {
                $('#reference_id').val('');
            }
        })

        loadDetails({
            type: 'nameWithNumber',
            selector: '#patient_name',
            url: requestUrl({
                path: 'loadPatient?type=',
                param: 'self',
            }),
            select: function (event, ui) {
                loadPatient(event, ui)
            }
        })
    }


    function corporateFilter(discountType)
    {
        corporateReset()

        $(document).on('change','#corporate_client_id', function () {
            let corporate_client_id = $(this).val();
            $.getJSON(requestUrl({path: 'load-corporate',}), {id: $(this).val()},
                function (corporate_client) {
                    let corporateBasedDiscount = 0;
                    if (discountType == "indoor") corporateBasedDiscount = corporate_client.indoor_discount;
                    if (discountType == "outdoor")  corporateBasedDiscount = corporate_client.outdoor_discount;
                    $('#discount').val(corporateBasedDiscount).attr('readonly', true);
                }
            )

            resetPatient();
            if (corporate_client_id != 0){
                $('#patient_name').val('').attr('readonly', false);
            }else{
                $('#patient_name').val('').attr('readonly', true);
            }
            loadDetails({
                    type: 'nameWithNumber',
                    selector: '#patient_name',
                    url: requestUrl({
                        path:  'loadPatient?corporate_client_id=',
                        param: corporate_client_id
                    }),
                    select: function (event, ui) {
                        loadPatient(event, ui)
                    },
                })

        })
    }

    function cardReset()
    {
        $('.card-section').removeClass('hidden');
        $('.corporate-section, .self').addClass('hidden');
        $('#reference_id').val('');
        $('#patient_name').val('').attr('readonly', true);
        $('#discount_group').removeClass('hidden', true);
    }
    function corporateReset()
    {
        $('#card-number, #reference-by, #reference_id').val('');
        $('.corporate-section').removeClass('hidden');
        $('.card-section, .self').addClass('hidden');
        $("#corporate_client_id").val("0").change();
        $('#patient_name').val('').attr('readonly', true);
        $('#discount_group').removeClass('hidden', true);
    }
    function selfReset()
    {
        $('#card-number, #reference-by').val('');
        $('.self').removeClass('hidden');
        $('.card-section, .corporate-section').addClass('hidden');
        $('#patient_name').val('').attr('readonly', false);
    }
