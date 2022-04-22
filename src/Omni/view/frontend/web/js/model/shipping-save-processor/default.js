;define([
    'jquery',
    'mage/utils/wrapper',
    'underscore'
], function ($, wrapper, _) {
    'use strict';

    return function (payloadExtender) {
        return wrapper.wrap(payloadExtender, function (originalFunction, payload) {
            let pickupDate = $('[name="pickup-date"]') ? $('[name="pickup-date"]').val() : '';
            let pickupTimeslot = $('[name="pickup-timeslot"]') ? $('[name="pickup-timeslot"]').val() : '';
            payload = originalFunction(payload);

            _.extend(payload.addressInformation, {
                extension_attributes: {
                    'pickup_store': $('#pickup-store').val(),
                    'pickup_date': pickupDate,
                    'pickup_timeslot': pickupTimeslot
                }
            });

            return payload;
        });
    };
});
