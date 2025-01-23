<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Notice - Agezweho</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            color: #333;
        }
        .container {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #2c3e50;
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
        }
        h2 {
            color: #34495e;
            margin-top: 25px;
        }
        .section {
            margin-bottom: 30px;
        }
        .summary {
            background: #f8f9fa;
            padding: 20px;
            border-left: 4px solid #2c3e50;
            margin: 20px 0;
        }
        .contact-info {
            background: #f1f1f1;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
        }
        .last-updated {
            color: #666;
            font-style: italic;
        }
    </style>
</head>
<body>
    <?php
    // Company information
    $company_name = "Agezweho";
    $company_email = "privacy@agezweho.com";
    $company_address = "24V7+XQW, Kigali, Rwanda";
    $last_updated = "January 19, 2025";
    $website_url = "https://agezweho.com";
    ?>

    <div class="container">
        <h1>Privacy Notice</h1>
        <p class="last-updated">Last updated: <?php echo $last_updated; ?></p>

        <div class="summary">
            <p>This Privacy Notice for <?php echo $company_name; ?> ("we," "us," or "our"), describes how and why we might access, collect, store, use, and/or share ("process") your personal information when you use our services ("Services"), including when you:</p>
            <ul>
                <li>Visit our website at <?php echo $website_url; ?>, or any website of ours that links to this Privacy Notice</li>
                <li>Download and use our mobile application (<?php echo $company_name; ?>), or any other application of ours that links to this Privacy Notice</li>
                <li>Use our news platform</li>
                <li>Engage with us in other related ways, including any sales, marketing, or events</li>
            </ul>
        </div>

        <div class="section">
            <h2>Summary of Key Points</h2>
            <?php
            $key_points = [
                "Personal Information" => "We may process personal information depending on how you interact with our Services.",
                "Sensitive Information" => "We do not process sensitive personal information.",
                "Third-Party Information" => "We do not collect any information from third parties.",
                "Information Processing" => "We process your information to provide, improve, and administer our Services, communicate with you, for security and fraud prevention, and to comply with law.",
                "Information Sharing" => "We may share information in specific situations and with specific third parties.",
                "Information Security" => "We have organizational and technical processes in place to protect your information.",
                "Your Rights" => "You have certain rights regarding your personal information depending on your location.",
            ];

            echo "<ul>";
            foreach ($key_points as $title => $description) {
                echo "<li><strong>$title:</strong> $description</li>";
            }
            echo "</ul>";
            ?>
        </div>

        <?php
        $sections = [
            "1. What Information Do We Collect?" => [
                "Personal information you disclose to us",
                "Information automatically collected"
            ],
            "2. How Do We Process Your Information?" => [
                "To facilitate account creation and management",
                "To respond to user inquiries and support",
                "To request feedback"
            ],
            "3. When and With Whom Do We Share Your Personal Information?" => [
                "Vendors, Consultants, and Third-Party Service Providers",
                "Business Transfers"
            ],
            "4. Do We Use Cookies and Other Tracking Technologies?" => [
                "We use cookies and similar tracking technologies",
                "Google Analytics implementation"
            ],
            "5. How Long Do We Keep Your Information?" => [
                "Information retention policies",
                "Data deletion and anonymization"
            ],
            "6. How Do We Keep Your Information Safe?" => [
                "Security measures",
                "Transmission risks"
            ],
            "7. Do We Collect Information From Minors?" => [
                "Age restrictions",
                "Minor data protection"
            ],
            "8. What Are Your Privacy Rights?" => [
                "Account information",
                "Consent withdrawal",
                "Data access and control"
            ],
            "9. Controls for Do-Not-Track Features" => [
                "Browser settings",
                "Tracking technology"
            ],
            "10. Do We Make Updates to This Notice?" => [
                "Policy updates",
                "Notification procedures"
            ]
        ];

        foreach ($sections as $title => $subsections) {
            echo "<div class='section'>";
            echo "<h2>$title</h2>";
            echo "<div class='content'>";
            foreach ($subsections as $subsection) {
                echo "<h3>$subsection</h3>";
                // Content would be populated here based on the privacy notice
                echo "<p>Details for $subsection would be included here.</p>";
            }
            echo "</div></div>";
        }
        ?>

        <div class="contact-info">
            <h2>11. How Can You Contact Us About This Notice?</h2>
            <p>If you have questions or comments about this notice, you may email us at <?php echo $company_email; ?> or contact us by post at:</p>
            <address>
                <?php echo $company_name; ?><br>
                <?php echo $company_address; ?><br>
                Kigali, Kigali<br>
                Rwanda
            </address>
        </div>

        <div class="section">
            <h2>12. How Can You Review, Update, or Delete the Data We Collect From You?</h2>
            <p>You have the right to request access to the personal information we collect from you, change it, or delete it. You can exercise these rights by visiting: <a href="<?php echo $website_url; ?>/admin/features-settings.html">our settings page</a>.</p>
        </div>
    </div>
</body>
</html>