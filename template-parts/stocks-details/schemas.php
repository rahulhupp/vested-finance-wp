<?php
/**
 * Stock Details Structured Data Schemas
 * 
 * This template generates all structured data (JSON-LD) schemas for stock and ETF detail pages.
 * Includes: Website, FinancialProduct, BreadcrumbList, and InvestmentFund schemas.
 * 
 * @package Vested Finance
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Get passed arguments
$overview_data = isset($args['overview_data']) ? $args['overview_data'] : null;
$returns_data = isset($args['returns_data']) ? $args['returns_data'] : null;
$get_path = isset($args['get_path']) ? $args['get_path'] : [];
$summary_mapping = isset($args['summary_mapping']) ? $args['summary_mapping'] : [];

// Validate required data
if (empty($overview_data)) {
    return; // Exit if no overview data available
}

// Extract common data
$is_etf = vf_is_etf_page($get_path);
$current_url = vf_get_current_stock_url();
$home_url = home_url('/');
$stock_name = vf_schema_sanitize_string($overview_data->name);
$ticker = vf_schema_sanitize_string($overview_data->ticker);
$stock_price = vf_format_price($overview_data->price);
$stock_description = vf_get_stock_description($overview_data);
$fund_type = vf_get_fund_type($overview_data, $is_etf);

// Extract 52-week range
$range_item = isset($summary_mapping["52-Week Range"]) ? $summary_mapping["52-Week Range"] : null;
$low_range = isset($range_item['low']) && is_numeric($range_item['low']) ? vf_format_price($range_item['low']) : $stock_price;
$high_range = isset($range_item['high']) && is_numeric($range_item['high']) ? vf_format_price($range_item['high']) : $stock_price;

// Extract market cap
$market_cap_value = isset($summary_mapping["Market Cap"]) ? $summary_mapping["Market Cap"] : '';
$market_cap_numeric = vf_parse_market_cap($market_cap_value);

// Build schema data arrays
$breadcrumb_items = vf_build_breadcrumb_items($overview_data, $is_etf);
$investment_fund_types = vf_get_investment_fund_types($overview_data->tags ?? []);
$fund_performance = vf_format_fund_performance($returns_data);
$ticker_with_exchange = vf_get_ticker_with_exchange($overview_data);

?>

<!-- Website Schema -->
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@graph": [
        {
            "@type": "WebSite",
            "@id": "<?php echo esc_url($home_url); ?>#website",
            "url": "<?php echo esc_url($home_url); ?>",
            "name": "Vested Finance",
            "description": "Invest in US stocks and ETFs from India with Vested Finance",
            "publisher": {
                "@id": "<?php echo esc_url($home_url); ?>#organization"
            },
            "potentialAction": [
                {
                    "@type": "SearchAction",
                    "target": {
                        "@type": "EntryPoint",
                        "urlTemplate": "<?php echo esc_url($home_url); ?>?s={search_term_string}"
                    },
                    "query-input": "required name=search_term_string"
                }
            ],
            "inLanguage": "en-US"
        },
        {
            "@type": "Organization",
            "@id": "<?php echo esc_url($home_url); ?>#organization",
            "name": "Vested Finance",
            "url": "<?php echo esc_url($home_url); ?>",
            "logo": {
                "@type": "ImageObject",
                "inLanguage": "en-US",
                "@id": "<?php echo esc_url($home_url); ?>#/schema/logo/image/",
                "url": "<?php echo esc_url(vf_get_logo_url()); ?>",
                "contentUrl": "<?php echo esc_url(vf_get_logo_url()); ?>",
                "caption": "Vested Finance"
            },
            "image": {
                "@id": "<?php echo esc_url($home_url); ?>#/schema/logo/image/"
            }
        }
    ]
}
</script>

<!-- BreadcrumbList Schema -->
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [
        <?php
        $breadcrumb_json_items = [];
        foreach ($breadcrumb_items as $item) {
            $breadcrumb_json_items[] = json_encode($item, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        }
        echo implode(",\n        ", $breadcrumb_json_items);
        ?>
    ]
}
</script>

<!-- FinancialProduct Schema -->
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "FinancialProduct",
    "@id": "<?php echo esc_url($current_url); ?>#financialproduct",
    "name": "<?php echo $stock_name; ?> (<?php echo $ticker; ?>)",
    "identifier": "<?php echo $ticker; ?>",
    "url": "<?php echo esc_url($current_url); ?>",
    "description": "<?php echo $stock_description; ?>",
    "category": "<?php echo $fund_type; ?>",
    "offers": {
        "@type": "Offer",
        "priceCurrency": "USD",
        "price": "<?php echo $stock_price; ?>",
        "highPrice": "<?php echo $high_range; ?>",
        "lowPrice": "<?php echo $low_range; ?>",
        "url": "<?php echo esc_url($current_url); ?>",
        "availability": "https://schema.org/InStock",
        "seller": {
            "@type": "Organization",
            "name": "Vested Finance"
        }
    }
}
</script>

<!-- InvestmentFund Schema -->
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "InvestmentFund",
    "@id": "<?php echo esc_url($current_url); ?>#investmentfund",
    "name": "<?php echo $stock_name; ?> (<?php echo $ticker; ?>) <?php echo $fund_type; ?>",
    "description": "<?php echo $stock_description; ?>",
    "url": "<?php echo esc_url($current_url); ?>",
    "category": "Public Equity",
    "fundType": "<?php echo $fund_type; ?>",
    "investmentFundType": <?php echo json_encode($investment_fund_types, JSON_UNESCAPED_SLASHES); ?>,
    "hasTickerSymbol": {
        "@type": "PropertyValue",
        "propertyID": "tickerSymbol",
        "value": "<?php echo $ticker_with_exchange; ?>"
    },
    "managementCompany": {
        "@type": "Organization",
        "name": "<?php echo $stock_name; ?>"<?php if (!empty($overview_data->description)): ?>,
        "description": "<?php echo $stock_description; ?>"
        <?php endif; ?>
    },
    "nav": {
        "@type": "MonetaryAmount",
        "value": "<?php echo $stock_price; ?>",
        "currency": "USD"
    }<?php if (!empty($market_cap_numeric) && $market_cap_numeric > 0): ?>,
    "totalAssets": {
        "@type": "MonetaryAmount",
        "value": "<?php echo $market_cap_numeric; ?>",
        "currency": "USD"
    }
    <?php endif; ?><?php if (!empty($fund_performance)): ?>,
    "fundPerformance": <?php echo json_encode($fund_performance, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT); ?>
    <?php endif; ?>,
    "distribution": [
        {
            "@type": "Offer",
            "price": "<?php echo $stock_price; ?>",
            "priceCurrency": "USD",
            "url": "<?php echo esc_url($current_url); ?>",
            "availability": "https://schema.org/InStock",
            "seller": {
                "@type": "Organization",
                "name": "Vested Finance",
                "url": "<?php echo esc_url($home_url); ?>"
            }
        }
    ]
}
</script>

