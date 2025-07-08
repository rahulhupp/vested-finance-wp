<?php
/**
 * Template name: Page - IPO Landing Page
 * Lists all available IPOs with basic information
 */

get_header();

// Get all IPOs from database
global $wpdb;
$table_name = $wpdb->prefix . 'ipo_list';
$ipos = $wpdb->get_results("SELECT * FROM $table_name ORDER BY name ASC");

// Helper function to generate IPO slug (same as in ipo-details-functions.php)
function generate_pre_ipo_slug($name) {
    // Convert to lowercase
    $slug = strtolower($name);
    
    // Replace spaces and special characters with hyphens
    $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
    $slug = preg_replace('/[\s-]+/', '-', $slug);
    
    // Remove leading/trailing hyphens
    $slug = trim($slug, '-');
    
    // Limit length
    if (strlen($slug) > 100) {
        $slug = substr($slug, 0, 100);
        $slug = rtrim($slug, '-');
    }
    
    return $slug;
}

// Helper function to check if IPO has full data
function check_ipo_has_full_data($ipo_id) {
    $investors_data = get_ipo_investors($ipo_id);
    return !empty($investors_data['items']);
}
?>

<div class="ipo-landing-main">
    <div class="container">
        <div class="ipo-landing-header">
            <h1>Pre-IPO Investment Opportunities</h1>
            <p>Browse all available pre-IPO investment opportunities</p>
        </div>

        <div class="ipo-landing-content">
            <?php if (!empty($ipos)): ?>
                <div class="ipo-list-table">
                    <table>
                        <thead>
                            <tr>
                                <th>Company Name</th>
                                <th>IPO ID</th>
                                <th>Data Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($ipos as $ipo): ?>
                                <?php 
                                $ipo_slug = generate_pre_ipo_slug($ipo->name);
                                $ipo_url = home_url('/in/pre-ipo/' . $ipo_slug . '/');
                                ?>
                                <tr>
                                    <td>
                                        <strong><?php echo esc_html($ipo->name); ?></strong>
                                    </td>
                                    <td>
                                        <?php echo esc_html($ipo->ipo_id); ?>
                                    </td>
                                    <td>
                                        <?php 
                                        $has_full_data = check_ipo_has_full_data($ipo->ipo_id);
                                        if ($has_full_data): ?>
                                            <span class="data-status-full">Full Data</span>
                                        <?php else: ?>
                                            <span class="data-status-basic">Basic Data</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?php echo esc_url($ipo_url); ?>" class="ipo-view-link" target="_blank">
                                            View Details
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="ipo-summary">
                    <h3>Summary</h3>
                    <p>Total IPOs available: <strong><?php echo count($ipos); ?></strong></p>
                </div>

            <?php else: ?>
                <div class="ipo-no-data">
                    <h3>No IPOs Available</h3>
                    <p>No IPO data found in the database.</p>
                </div>
            <?php endif; ?>
        </div>

        <div class="ipo-debug-info">
            <h3>Debug Information</h3>
            <p><strong>Database Table:</strong> <?php echo $table_name; ?></p>
            <p><strong>Total Records:</strong> <?php echo $wpdb->get_var("SELECT COUNT(*) FROM $table_name"); ?></p>
        </div>
    </div>
</div>

<style>
/* Basic styling for the landing page */
.ipo-landing-main {
    padding: 40px 0;
    background-color: #f5f5f5;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.ipo-landing-header {
    text-align: center;
    margin-bottom: 40px;
}

.ipo-landing-header h1 {
    font-size: 2.5em;
    margin-bottom: 10px;
    color: #333;
}

.ipo-landing-header p {
    font-size: 1.2em;
    color: #666;
}

.ipo-list-table {
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    margin-bottom: 30px;
}

.ipo-list-table table {
    width: 100%;
    border-collapse: collapse;
}

.ipo-list-table th,
.ipo-list-table td {
    padding: 15px;
    text-align: left;
    border-bottom: 1px solid #eee;
}

.ipo-list-table th {
    background-color: #f8f9fa;
    font-weight: 600;
    color: #333;
}

.ipo-list-table tr:hover {
    background-color: #f8f9fa;
}

.ipo-view-link {
    display: inline-block;
    padding: 8px 16px;
    background-color: #007cba;
    color: white;
    text-decoration: none;
    border-radius: 4px;
    font-size: 14px;
}

.ipo-view-link:hover {
    background-color: #005a87;
    color: white;
}

.data-status-full {
    display: inline-block;
    padding: 4px 8px;
    background-color: #28a745;
    color: white;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 500;
}

.data-status-basic {
    display: inline-block;
    padding: 4px 8px;
    background-color: #ffc107;
    color: #212529;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 500;
}

.ipo-summary {
    background: white;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 30px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.ipo-no-data {
    background: white;
    padding: 40px;
    text-align: center;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.ipo-debug-info {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    border: 1px solid #dee2e6;
    font-family: monospace;
    font-size: 14px;
}

code {
    background-color: #f1f3f4;
    padding: 2px 6px;
    border-radius: 3px;
    font-family: monospace;
    font-size: 12px;
}
</style>

<?php get_footer(); ?> 