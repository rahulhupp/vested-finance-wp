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

// Extract P/E Ratio
$pe_ratio = isset($summary_mapping["P/E Ratio"]) ? $summary_mapping["P/E Ratio"] : '';

// Build schema data arrays
$breadcrumb_items = vf_build_breadcrumb_items($overview_data, $is_etf);
$investment_fund_types = vf_get_investment_fund_types($overview_data->tags ?? []);
$fund_performance = vf_format_fund_performance($returns_data);
$ticker_with_exchange = vf_get_ticker_with_exchange($overview_data);

// Extract sector, industry and market cap category from tags
$sector = '';
$industry = '';
$market_cap_category = '';
if (!empty($overview_data->tags) && is_array($overview_data->tags)) {
    foreach ($overview_data->tags as $tag) {
        if (isset($tag->label) && isset($tag->value)) {
            $label = strtolower($tag->label);
            $value = vf_schema_sanitize_string($tag->value);

            if ($label === 'sector') {
                $sector = $value;
            }
            if ($label === 'industry') {
                $industry = $value;
            }
            if ($label === 'market cap' || $label === 'market capitalization') {
                $market_cap_category = $value;
            }
        }
    }
}

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
            "description": "Invest in US stocks from India with Vested Finance. Access 5000+ US stocks and ETFs with fractional investing starting from $1.",
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
            "legalName": "Vested Finance Inc.",
            "url": "<?php echo esc_url($home_url); ?>",
            "description": "Vested Finance enables Indians to invest in US stocks and ETFs. Open a US brokerage account and start investing in over 5000+ US stocks with fractional shares from $1.",
            "logo": {
                "@type": "ImageObject",
                "inLanguage": "en-US",
                "@id": "<?php echo esc_url($home_url); ?>#/schema/logo/image/",
                "url": "<?php echo esc_url(vf_get_logo_url()); ?>",
                "contentUrl": "<?php echo esc_url(vf_get_logo_url()); ?>",
                "width": "300",
                "height": "60",
                "caption": "Vested Finance"
            },
            "image": {
                "@id": "<?php echo esc_url($home_url); ?>#/schema/logo/image/"
            },
            "contactPoint": {
                "@type": "ContactPoint",
                "contactType": "Customer Support",
                "email": "support@vestedfinance.com",
                "areaServed": "IN",
                "availableLanguage": ["English", "Hindi"]
            },
            "sameAs": [
                "https://www.linkedin.com/company/vestedfinance/",
                "https://twitter.com/vestedfinance",
                "https://www.facebook.com/vestedfinance",
                "https://www.instagram.com/vestedfinance/"
            ]
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
    "name": "<?php echo $stock_name; ?>",
    "alternateName": "<?php echo $stock_name; ?>",
    "description": "<?php echo $stock_description; ?>",
    "identifier": "<?php echo $ticker; ?>",
    "url": "<?php echo esc_url($current_url); ?>",
    "category": "<?php echo $fund_type; ?>",
    "image": "https://d13dxy5z8now6z.cloudfront.net/symbol/<?php echo $ticker; ?>.png",
    "provider": {
        "@type": "Organization",
        "name": "Vested Finance",
        "url": "<?php echo esc_url($home_url); ?>",
        "logo": "<?php echo esc_url(vf_get_logo_url()); ?>"
    },
    "offers": {
        "@type": "Offer",
        "price": "<?php echo $stock_price; ?>",
        "priceCurrency": "USD",
        "priceValidUntil": "<?php echo date('Y-m-d\\TH:i:sP', strtotime('+1 day')); ?>",
        "availability": "https://schema.org/InStock",
        "url": "<?php echo esc_url($current_url); ?>"
    },
    "additionalProperty": [
        {
            "@type": "PropertyValue",
            "name": "Stock Exchange",
            "value": "<?php echo !empty($overview_data->exchange) ? $overview_data->exchange : 'NASDAQ'; ?>"
        },
        {
            "@type": "PropertyValue",
            "name": "Ticker Symbol",
            "value": "<?php echo $ticker; ?>"
        },
        {
            "@type": "PropertyValue",
            "name": "Current Price",
            "value": "$<?php echo $stock_price; ?> USD"
        }<?php if (!empty($high_range)): ?>,
        {
            "@type": "PropertyValue",
            "name": "52-Week High",
            "value": "$<?php echo $high_range; ?> USD"
        }
        <?php endif; ?><?php if (!empty($low_range)): ?>,
        {
            "@type": "PropertyValue",
            "name": "52-Week Low",
            "value": "$<?php echo $low_range; ?> USD"
        }
        <?php endif; ?><?php if (!empty($market_cap_numeric) && $market_cap_numeric > 0): ?>,
        {
            "@type": "PropertyValue",
            "name": "Market Capitalization",
            "value": "<?php 
                $market_cap_billions = $market_cap_numeric / 1000000000;
                $market_cap_trillions = $market_cap_numeric / 1000000000000;
                if ($market_cap_trillions >= 1) {
                    echo '$' . number_format($market_cap_trillions, 2) . ' Trillion USD';
                } else {
                    echo '$' . number_format($market_cap_billions, 2) . ' Billion USD';
                }
            ?>"
        }
        <?php endif; ?><?php if (!empty($pe_ratio)): ?>,
        {
            "@type": "PropertyValue",
            "name": "Price-to-Earnings Ratio",
            "value": "<?php echo $pe_ratio; ?>"
        }
        <?php endif; ?><?php if (!empty($sector)): ?>,
        {
            "@type": "PropertyValue",
            "name": "Sector",
            "value": "<?php echo $sector; ?>"
        }
        <?php endif; ?><?php if (!empty($industry)): ?>,
        {
            "@type": "PropertyValue",
            "name": "Industry",
            "value": "<?php echo $industry; ?>"
        }
        <?php endif; ?>,
        {
            "@type": "PropertyValue",
            "name": "Minimum Investment",
            "value": "$1 USD (Fractional shares available)"
        }
    ]
}
</script>

<!-- InvestmentFund Schema -->
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "InvestmentFund",
    "@id": "<?php echo esc_url($current_url); ?>#investmentfund",
    "name": "<?php echo $stock_name; ?> (<?php echo $ticker; ?>) <?php echo $fund_type; ?>",
    "alternateName": "<?php echo $stock_name; ?> Stock",
    "description": "<?php echo $stock_description; ?>",
    "url": "<?php echo esc_url($current_url); ?>",
    "identifier": "<?php echo $ticker; ?>",
    "image": "https://d13dxy5z8now6z.cloudfront.net/symbol/<?php echo $ticker; ?>.png",
    "provider": {
        "@type": "Organization",
        "name": "Vested Finance",
        "url": "<?php echo esc_url($home_url); ?>"
    },
    "broker": {
        "@type": "Organization",
        "name": "<?php echo !empty($overview_data->exchange) ? $overview_data->exchange : 'NASDAQ'; ?>",
        "url": "https://www.nasdaq.com"
    },
    "feesAndCommissionsSpecification": "Zero commission trading available through Vested Finance. Currency conversion and regulatory charges may apply.",
    "offers": {
        "@type": "Offer",
        "price": "<?php echo $stock_price; ?>",
        "priceCurrency": "USD",
        "priceValidUntil": "<?php echo date('Y-m-d\TH:i:sP', strtotime('+1 day')); ?>",
        "availability": "https://schema.org/InStock",
        "url": "<?php echo esc_url($current_url); ?>"
    },
    "sameAs": [
        "https://www.nasdaq.com/market-activity/stocks/<?php echo strtolower($ticker); ?>"
    ],
    "additionalProperty": [
        {
            "@type": "PropertyValue",
            "name": "Category",
            "value": "Public Equity"
        },
        {
            "@type": "PropertyValue",
            "name": "Fund Type",
            "value": "<?php echo $fund_type; ?>"
        },
        {
            "@type": "PropertyValue",
            "name": "Investment Type",
            "value": "<?php echo !empty($investment_fund_types[0]) ? $investment_fund_types[0] : 'Equity'; ?>"
        }<?php if (!empty($sector)): ?>,
        {
            "@type": "PropertyValue",
            "name": "Sector",
            "value": "<?php echo $sector; ?>"
        }
        <?php endif; ?><?php if (!empty($market_cap_category)): ?>,
        {
            "@type": "PropertyValue",
            "name": "Market Cap Category",
            "value": "<?php echo $market_cap_category; ?>"
        }
        <?php endif; ?>,
        {
            "@type": "PropertyValue",
            "name": "Stock Exchange",
            "value": "<?php echo !empty($overview_data->exchange) ? $overview_data->exchange : 'NASDAQ'; ?>"
        },
        {
            "@type": "PropertyValue",
            "name": "Ticker Symbol Full",
            "value": "<?php echo $ticker_with_exchange; ?>"
        },
        {
            "@type": "PropertyValue",
            "name": "Current NAV/Price",
            "value": "$<?php echo $stock_price; ?> USD"
        }<?php if (!empty($market_cap_numeric) && $market_cap_numeric > 0): ?>,
        {
            "@type": "PropertyValue",
            "name": "Total Assets / Market Cap",
            "value": "<?php 
                $market_cap_billions = $market_cap_numeric / 1000000000;
                $market_cap_trillions = $market_cap_numeric / 1000000000000;
                if ($market_cap_trillions >= 1) {
                    echo '$' . number_format($market_cap_trillions, 2) . ' Trillion USD';
                } else {
                    echo '$' . number_format($market_cap_billions, 2) . ' Billion USD';
                }
            ?>"
        }
        <?php endif; ?><?php 
        // Add fund performance as additional properties (only 1-Year and 5-Year to match client format)
        if (!empty($fund_performance)) {
            foreach ($fund_performance as $performance) {
                // Only show 1-Year and 5-Year returns to match client format
                if ($performance['name'] === '1-Year Return' || $performance['name'] === '5-Year Return') {
                    echo ',
        {
            "@type": "PropertyValue",
            "name": "' . $performance['name'] . '",
            "value": "' . $performance['amount']['value'] . '%"
        }';
                }
            }
        }
        ?><?php if (!empty($high_range)): ?>,
        {
            "@type": "PropertyValue",
            "name": "52-Week High",
            "value": "$<?php echo $high_range; ?> USD"
        }
        <?php endif; ?><?php if (!empty($low_range)): ?>,
        {
            "@type": "PropertyValue",
            "name": "52-Week Low",
            "value": "$<?php echo $low_range; ?> USD"
        }
        <?php endif; ?><?php if (!empty($pe_ratio)): ?>,
        {
            "@type": "PropertyValue",
            "name": "Price-to-Earnings Ratio",
            "value": "<?php echo $pe_ratio; ?>"
        }
        <?php endif; ?>,
        {
            "@type": "PropertyValue",
            "name": "Rating Value",
            "value": ""
        },
        {
            "@type": "PropertyValue",
            "name": "Number of Ratings",
            "value": ""
        },
        {
            "@type": "PropertyValue",
            "name": "Minimum Investment",
            "value": "$1 USD (Fractional shares available)"
        }
    ]
}
</script>

