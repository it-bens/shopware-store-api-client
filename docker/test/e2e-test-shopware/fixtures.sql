use shopware_test;

UPDATE `shopware_test`.`sales_channel_domain` SET `shopware_test`.`sales_channel_domain`.`url` = "http://e2e-test-shopware:80";
UPDATE `shopware_test`.`sales_channel` SET `shopware_test`.`sales_channel`.`access_key` = "SWSCVNDQREY4RVMWD01PSEF4WA";

SELECT @defaultCustomerGroupId := `id` FROM `customer_group` LIMIT 1;
SELECT @defaultPaymentMethodId := `id` FROM `payment_method` WHERE `handler_identifier` LIKE 'Shopware\\\\Core\\\\Checkout\\\\Payment\\\\Cart\\\\PaymentHandler\\\\PrePayment' LIMIT 1;
SELECT @defaultSalesChannelId := `id` FROM `sales_channel` LIMIT 1;
SELECT @germanLanguageId := `id` FROM `language` WHERE `name` LIKE 'Deutsch';
SELECT @germanyCountryId := `id` FROM `country` WHERE `iso` LIKE 'DE';
SELECT @standardTaxId := `id` FROM `tax` WHERE `name` LIKE 'Standard rate';
SELECT @salutationId := `id` FROM `salutation` WHERE `salutation_key` LIKE 'not_specified';

SET @customerId = UNHEX(UPPER('39ab383c14d64b45acfdf3e694b7a656'));
SET @customerAddressId = UNHEX(UPPER('02e6af230d424676b12405b8e970dec7'));
SET @customerEmail = 'super@mario.nintendo';
SET @customerPassword = '12345678';
SET @customerPasswordHashedWithBcrypt = '$2y$10$8D2PAMgdV74U12P3ltT6mukNE01H7T6HYXWNXLoy9cgnDQdSsgeX2';

INSERT INTO `customer` (`id`, `customer_group_id`, `default_payment_method_id`, `sales_channel_id`, `language_id`, `default_billing_address_id`, `default_shipping_address_id`, `customer_number`, `first_name`, `last_name`, `email`, `active`, `double_opt_in_registration`, `guest`, `created_at`, `account_type`) VALUES(@customerId, @defaultCustomerGroupId, @defaultPaymentMethodId, @defaultSalesChannelId, @germanLanguageId, '', '', '797869', 'Charles', 'Martinet', @customerEmail, 1, 0, 0, NOW(), 'private');
INSERT INTO `customer_address` (`id`, `customer_id`, `country_id`, `salutation_id`, `first_name`, `last_name`, `street`, `zipcode`, `city`, `created_at`) VALUES(@customerAddressId, @customerId, @germanyCountryId, @salutationId, 'Charles', 'Martinet', 'Mushroom Kingdom', '12345', 'Nintendo City', NOW());
UPDATE `customer` SET `default_billing_address_id` = @customerAddressId, `default_shipping_address_id` = @customerAddressId, `password` = @customerPasswordHashedWithBcrypt WHERE `id` = @customerId;

SET @productId = UNHEX(UPPER('5db83d37dffb41cdbc71c29447483c29'));
SET @productVersionId = UNHEX(UPPER('0fa91ce3e96a4bc2be4bd9ce752c3425'));
SET @productName = 'Opel Kadett C Coupe, rot 1975, 1:18 Modellauto';
SET @productPrice = '{"cb7d2554b0ce847cd82f3ac9bd1c0dfca":{"currencyId":"b7d2554b0ce847cd82f3ac9bd1c0dfca","gross":64.95,"net":54.58,"linked":false}}';
SET @visibilityId = UNHEX(UPPER('5db83d37dffb41cdbc71c29447483c29'));

INSERT INTO `product` (`id`, `version_id`, `product_number`, `active`, `tax_id`, `price`, `stock`, `is_closeout`, `created_at`) VALUES(@productId, @productVersionId, '123456', 1, @standardTaxId, @productPrice, 5, 1, NOW());
INSERT INTO `product_translation` (`product_id`, `product_version_id`, `language_id`, `name`, `created_at`) VALUES(@productId, @productVersionId, @germanLanguageId, @productName, NOW());
INSERT INTO `product_visibility` (`id`, `product_id`, `product_version_id`, `sales_channel_id`, `visibility`, `created_at`) VALUES(@visibilityId, @productId, @productVersionId, @defaultSalesChannelId, 30, NOW());

SET @promotionId = UNHEX(UPPER('c742b32c520b4d16ae5d13e43dc51208'));
SET @promotionSalesChannelId = UNHEX(UPPER('1e245d4fb17742b18371d06a67658aee'));
SET @discountId = UNHEX(UPPER('01906e4f37f8705889cdc0ab7c841690'));

INSERT INTO `promotion` (`id`, `active`, `priority`, `code`, `use_codes`, `customer_restriction`, `prevent_combination`, `use_individual_codes`, `created_at`) VALUES(@promotionId, 1, 1, 'SUPER_10', 1, 0, 0, 0, NOW());
INSERT INTO `promotion_sales_channel` (`id`, `promotion_id`, `sales_channel_id`, `created_at`) VALUES(@promotionSalesChannelId, @promotionId, @defaultSalesChannelId, NOW());
INSERT INTO `promotion_translation` (`promotion_id`, `language_id`, `name`, `created_at`) VALUES(@promotionId, @germanLanguageId, 'Super 10% auf alles!', NOW());
INSERT INTO `promotion_discount` (`id`, `promotion_id`, `scope`, `type`, `value`, `consider_advanced_rules`, `created_at`) VALUES(@discountId, @promotionId, 'cart', 'percentage', 10, 0, NOW());