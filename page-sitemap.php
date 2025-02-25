<?php
/*
Template Name: Sitemap
*/
?>
<?php get_header() ?>

<?php 
    $hero['title'] = [
        [
            'text' => get_the_title(),
        ]
    ];
    $modifierClass = "second";
?>
<?php include(locate_template('flexible/hero/big-heading-tagline-hero.php', false, false)); ?>

<!--
//! Eli asi lo ves mejor?
//! cada grupo de paginas es c--sitemap-a__wrapper
//! el c--sitemap-a__wrapper__hd__title puede ser <a> o <p>
//! en c--sitemap-a__wrapper__bd__item estan como sus hijos, si esos hijos tienen mas hijos es c--sitemap-a__wrapper__bd__item__title + sus hijos y si no c--sitemap-a__wrapper__bd__item__content
-->

<section class="f--pb-15 f--pb-tablets-10">
    <div class="f--container">
        <div class="c--sitemap-a">
            <div class="c--sitemap-a__wrapper">
                <div class="c--sitemap-a__wrapper__hd">
                    <p class="c--sitemap-a__wrapper__hd__title">About SEI</p>
                </div>
                <div class="c--sitemap-a__wrapper__bd">
                    <div class="c--sitemap-a__wrapper__bd__item">
                        <a href="<?php echo home_url(); ?>/about/about-sei/" class="c--sitemap-a__wrapper__bd__item__content">About Us</a>
                    </div>
                    <div class="c--sitemap-a__wrapper__bd__item">
                        <a href="<?php echo home_url(); ?>/about/awards-and-recognition/" class="c--sitemap-a__wrapper__bd__item__content">Awards & Recognition</a>
                    </div>
                    <div class="c--sitemap-a__wrapper__bd__item">
                        <a href="<?php echo home_url(); ?>/about/leadership/" class="c--sitemap-a__wrapper__bd__item__content">Leadership Team</a>
                    </div>
                    <div class="c--sitemap-a__wrapper__bd__item">
                        <a href="<?php echo home_url(); ?>/about/newsroom/" class="c--sitemap-a__wrapper__bd__item__content">Newsroom</a>
                    </div>
                </div>
            </div>
            <div class="c--sitemap-a__wrapper">
                <div class="c--sitemap-a__wrapper__hd">
                    <p class="c--sitemap-a__wrapper__hd__title">Careers</p>
                </div>
                <div class="c--sitemap-a__wrapper__bd">
                    <div class="c--sitemap-a__wrapper__bd__item">
                        <a href="<?php echo home_url(); ?>/careers/careers/" class="c--sitemap-a__wrapper__bd__item__content">Careers</a>
                    </div>
                    <div class="c--sitemap-a__wrapper__bd__item">
                        <a href="<?php echo home_url(); ?>/careers/open-positions/" class="c--sitemap-a__wrapper__bd__item__content">Open Positions</a>
                    </div>
                </div>
            </div>
            <div class="c--sitemap-a__wrapper">
                <div class="c--sitemap-a__wrapper__hd">
                    <a href="<?php echo home_url(); ?>/capabilities/" class="c--sitemap-a__wrapper__hd__title">Capabilities</a>
                </div>
                <div class="c--sitemap-a__wrapper__bd">
                    <div class="c--sitemap-a__wrapper__bd__item">
                        <a href="<?php echo home_url(); ?>/capabilities/ai-technology/" class="c--sitemap-a__wrapper__bd__item__title">AI & Technology</a>
                        <a href="<?php echo home_url(); ?>/capabilities/ai-technology/agile-transformation/" class="c--sitemap-a__wrapper__bd__item__content">Agile Transformation</a>
                        <a href="<?php echo home_url(); ?>/capabilities/ai-technology/application-development/" class="c--sitemap-a__wrapper__bd__item__content">Application Development</a>
                        <a href="<?php echo home_url(); ?>/capabilities/ai-technology/cloud-technology-strategies/" class="c--sitemap-a__wrapper__bd__item__content">Cloud & Technology Strategies</a>
                        <a href="<?php echo home_url(); ?>/capabilities/ai-technology/devops/" class="c--sitemap-a__wrapper__bd__item__content">Dev Ops</a>
                        <a href="<?php echo home_url(); ?>/capabilities/ai-technology/olution-design/" class="c--sitemap-a__wrapper__bd__item__content">Solution Design</a>
                    </div>
                    <div class="c--sitemap-a__wrapper__bd__item">
                        <a href="<?php echo home_url(); ?>/capabilities/concept-to-delivery/" class="c--sitemap-a__wrapper__bd__item__title">Concept to Delivery</a>
                        <a href="<?php echo home_url(); ?>/capabilities/concept-to-delivery/change-management/" class="c--sitemap-a__wrapper__bd__item__content">Change Management</a>
                        <a href="<?php echo home_url(); ?>/capabilities/concept-to-delivery/design-thinking/" class="c--sitemap-a__wrapper__bd__item__content">Design Thinking</a>
                        <a href="<?php echo home_url(); ?>/capabilities/concept-to-delivery/product-management/" class="c--sitemap-a__wrapper__bd__item__content">Product Management</a>
                        <a href="<?php echo home_url(); ?>/capabilities/concept-to-delivery/rapid-prototyping/" class="c--sitemap-a__wrapper__bd__item__content">Rapid Prototyping</a>
                        <a href="<?php echo home_url(); ?>/capabilities/concept-to-delivery/solution-delivery/" class="c--sitemap-a__wrapper__bd__item__content">Solution Delivery</a>
                    </div>
                    <div class="c--sitemap-a__wrapper__bd__item">
                        <a href="<?php echo home_url(); ?>/capabilities/data-and-analytics/" class="c--sitemap-a__wrapper__bd__item__title">Data & Analytics</a>
                        <a href="<?php echo home_url(); ?>/capabilities/data-and-analytics/advanced-analytics/" class="c--sitemap-a__wrapper__bd__item__content">Advanced Analytics</a>
                        <a href="<?php echo home_url(); ?>/capabilities/data-and-analytics/data-governance/" class="c--sitemap-a__wrapper__bd__item__content">Data Governance</a>
                        <a href="<?php echo home_url(); ?>/capabilities/data-and-analytics/data-modernization/" class="c--sitemap-a__wrapper__bd__item__content">Data Modernization</a>
                        <a href="<?php echo home_url(); ?>/capabilities/data-and-analytics/data-strategy/" class="c--sitemap-a__wrapper__bd__item__content">Data Strategy</a>
                        <a href="<?php echo home_url(); ?>/capabilities/data-and-analytics/data-visualization/" class="c--sitemap-a__wrapper__bd__item__content">Data Visualization</a>
                    </div>
                    <div class="c--sitemap-a__wrapper__bd__item">
                        <a href="<?php echo home_url(); ?>/capabilities/security-risk-and-compliance/" class="c--sitemap-a__wrapper__bd__item__title">Security, Risk & Compliance</a>
                        <a href="<?php echo home_url(); ?>/capabilities/security-risk-and-compliance/compliance/" class="c--sitemap-a__wrapper__bd__item__content">Compliance</a>
                        <a href="<?php echo home_url(); ?>/capabilities/security-risk-and-compliance/data-privacy/" class="c--sitemap-a__wrapper__bd__item__content">Data Privacy</a>
                        <a href="<?php echo home_url(); ?>/capabilities/security-risk-and-compliance/information-security/" class="c--sitemap-a__wrapper__bd__item__content">Information Security</a>
                        <a href="<?php echo home_url(); ?>/capabilities/security-risk-and-compliance/risk-management/" class="c--sitemap-a__wrapper__bd__item__content">Risk Management</a>
                    </div>
                    <div class="c--sitemap-a__wrapper__bd__item">
                        <a href="<?php echo home_url(); ?>/capabilities/strategy-and-operations/" class="c--sitemap-a__wrapper__bd__item__title">Strategy & Operations</a>
                        <a href="<?php echo home_url(); ?>/capabilities/strategy-and-operations/mergers-acquisitions/" class="c--sitemap-a__wrapper__bd__item__content">Mergers & Acquisitions</a>
                        <a href="<?php echo home_url(); ?>/capabilities/strategy-and-operations/operational-transformation/" class="c--sitemap-a__wrapper__bd__item__content">Operational Transformation</a>
                        <a href="<?php echo home_url(); ?>/capabilities/strategy-and-operations/organizational-design/" class="c--sitemap-a__wrapper__bd__item__content">Organization Design</a>
                        <a href="<?php echo home_url(); ?>/capabilities/strategy-and-operations/process-improvement/" class="c--sitemap-a__wrapper__bd__item__content">Process Improvement</a>
                        <a href="<?php echo home_url(); ?>/capabilities/strategy-and-operations/strategy-execution/" class="c--sitemap-a__wrapper__bd__item__content">Strategy & Execution</a>
                    </div>
                </div>
            </div>
            <div class="c--sitemap-a__wrapper">
                <div class="c--sitemap-a__wrapper__hd">
                    <a href="<?php echo home_url(); ?>/functions/" class="c--sitemap-a__wrapper__hd__title">Functions</a>
                </div>
            </div>
            <div class="c--sitemap-a__wrapper">
                <div class="c--sitemap-a__wrapper__hd">
                    <a href="<?php echo home_url(); ?>/industries/" class="c--sitemap-a__wrapper__hd__title">Industries</a>
                </div>
                <div class="c--sitemap-a__wrapper__bd">
                    <div class="c--sitemap-a__wrapper__bd__item">
                        <a href="<?php echo home_url(); ?>/industries/automotive-transportation/" class="c--sitemap-a__wrapper__bd__item__content">Automotive & Transportation</a>
                    </div>
                    <div class="c--sitemap-a__wrapper__bd__item">
                        <a href="<?php echo home_url(); ?>/industries/construction-and-real-estate/" class="c--sitemap-a__wrapper__bd__item__content">Construction & Real Estate</a>
                    </div>
                    <div class="c--sitemap-a__wrapper__bd__item">
                        <a href="<?php echo home_url(); ?>/industries/consumer-products/" class="c--sitemap-a__wrapper__bd__item__content">Consumer Products</a>
                    </div>
                    <div class="c--sitemap-a__wrapper__bd__item">
                        <a href="<?php echo home_url(); ?>/industries/environmental-services/" class="c--sitemap-a__wrapper__bd__item__content">Environmental Services</a>
                    </div>
                    <div class="c--sitemap-a__wrapper__bd__item">
                        <a href="<?php echo home_url(); ?>/industries/financial-services/" class="c--sitemap-a__wrapper__bd__item__content">Financial Services</a>
                    </div>
                    <div class="c--sitemap-a__wrapper__bd__item">
                        <a href="<?php echo home_url(); ?>/industries/government-services/" class="c--sitemap-a__wrapper__bd__item__content">Government Services</a>
                    </div>
                    <div class="c--sitemap-a__wrapper__bd__item">
                        <a href="<?php echo home_url(); ?>/industries/healthcare/" class="c--sitemap-a__wrapper__bd__item__content">Healthcare</a>
                    </div>
                    <div class="c--sitemap-a__wrapper__bd__item">
                        <a href="<?php echo home_url(); ?>/industries/higher-education/" class="c--sitemap-a__wrapper__bd__item__content">Higher Education</a>
                    </div>
                    <div class="c--sitemap-a__wrapper__bd__item">
                        <a href="<?php echo home_url(); ?>/industries/insurance/" class="c--sitemap-a__wrapper__bd__item__content">Insurance</a>
                    </div>
                    <div class="c--sitemap-a__wrapper__bd__item">
                        <a href="<?php echo home_url(); ?>/industries/leisure-hospitality/" class="c--sitemap-a__wrapper__bd__item__content">Leisure & Hospitality</a>
                    </div>
                    <div class="c--sitemap-a__wrapper__bd__item">
                        <a href="<?php echo home_url(); ?>/industries/life-sciences/" class="c--sitemap-a__wrapper__bd__item__content">Life Sciences</a>
                    </div>
                    <div class="c--sitemap-a__wrapper__bd__item">
                        <a href="<?php echo home_url(); ?>/industries/media-entertainment/" class="c--sitemap-a__wrapper__bd__item__content">Media & Entertainment</a>
                    </div>
                    <div class="c--sitemap-a__wrapper__bd__item">
                        <a href="<?php echo home_url(); ?>/industries/professional-services/" class="c--sitemap-a__wrapper__bd__item__content">Professional Services</a>
                    </div>
                    <div class="c--sitemap-a__wrapper__bd__item">
                        <a href="<?php echo home_url(); ?>/industries/retail-e-commerce/" class="c--sitemap-a__wrapper__bd__item__content">Retail & E-Commerce</a>
                    </div>
                    <div class="c--sitemap-a__wrapper__bd__item">
                        <a href="<?php echo home_url(); ?>/industries/supply-chain/" class="c--sitemap-a__wrapper__bd__item__content">Supply Chain</a>
                    </div>
                    <div class="c--sitemap-a__wrapper__bd__item">
                        <a href="<?php echo home_url(); ?>/industries/utilities/" class="c--sitemap-a__wrapper__bd__item__content">Utilities</a>
                    </div>
                </div>
            </div>
            <div class="c--sitemap-a__wrapper">
                <div class="c--sitemap-a__wrapper__hd">
                    <a href="<?php echo home_url(); ?>/insights/" class="c--sitemap-a__wrapper__hd__title">Insights</a>
                </div>
            </div>
            <div class="c--sitemap-a__wrapper">
                <div class="c--sitemap-a__wrapper__hd">
                    <a href="<?php echo home_url(); ?>/locations/" class="c--sitemap-a__wrapper__hd__title">Locations</a>
                </div>
                <div class="c--sitemap-a__wrapper__bd">
                    <div class="c--sitemap-a__wrapper__bd__item">
                        <a href="<?php echo home_url(); ?>/locations/atlanta/" class="c--sitemap-a__wrapper__bd__item__content">Atlanta</a>
                    </div>
                    <div class="c--sitemap-a__wrapper__bd__item">
                        <a href="<?php echo home_url(); ?>/locations/boston/" class="c--sitemap-a__wrapper__bd__item__content">Boston</a>
                    </div>
                    <div class="c--sitemap-a__wrapper__bd__item">
                        <a href="<?php echo home_url(); ?>/locations/charlotte/" class="c--sitemap-a__wrapper__bd__item__content">Charlotte</a>
                    </div>
                    <div class="c--sitemap-a__wrapper__bd__item">
                        <a href="<?php echo home_url(); ?>/locations/chicago/" class="c--sitemap-a__wrapper__bd__item__content">Chicago</a>
                    </div>
                    <div class="c--sitemap-a__wrapper__bd__item">
                        <a href="<?php echo home_url(); ?>/locations/cincinnati/" class="c--sitemap-a__wrapper__bd__item__content">Cincinnati</a>
                    </div>
                    <div class="c--sitemap-a__wrapper__bd__item">
                        <a href="<?php echo home_url(); ?>/locations/dallas/" class="c--sitemap-a__wrapper__bd__item__content">Dallas</a>
                    </div>
                    <div class="c--sitemap-a__wrapper__bd__item">
                        <a href="<?php echo home_url(); ?>/locations/miami/" class="c--sitemap-a__wrapper__bd__item__content">Miami</a>
                    </div>
                    <div class="c--sitemap-a__wrapper__bd__item">
                        <a href="<?php echo home_url(); ?>/locations/nashville/" class="c--sitemap-a__wrapper__bd__item__content">Nashville</a>
                    </div>
                    <div class="c--sitemap-a__wrapper__bd__item">
                        <a href="<?php echo home_url(); ?>/locations/new-york/" class="c--sitemap-a__wrapper__bd__item__content">New York</a>
                    </div>
                    <div class="c--sitemap-a__wrapper__bd__item">
                        <a href="<?php echo home_url(); ?>/locations/philadelphia/" class="c--sitemap-a__wrapper__bd__item__content">Philadelphia</a>
                    </div>
                    <div class="c--sitemap-a__wrapper__bd__item">
                        <a href="<?php echo home_url(); ?>/locations/phoenix/" class="c--sitemap-a__wrapper__bd__item__content">Phoenix</a>
                    </div>
                    <div class="c--sitemap-a__wrapper__bd__item">
                        <a href="<?php echo home_url(); ?>/locations/seattle/" class="c--sitemap-a__wrapper__bd__item__content">Seattle</a>
                    </div>
                    <div class="c--sitemap-a__wrapper__bd__item">
                        <a href="<?php echo home_url(); ?>/locations/shared-services/" class="c--sitemap-a__wrapper__bd__item__content">Shared Services</a>
                    </div>
                    <div class="c--sitemap-a__wrapper__bd__item">
                        <a href="<?php echo home_url(); ?>/locations/washington-dc/" class="c--sitemap-a__wrapper__bd__item__content">Washington D.C.</a>
                    </div>
                </div>
            </div>
            <div class="c--sitemap-a__wrapper">
                <div class="c--sitemap-a__wrapper__hd">
                    <p class="c--sitemap-a__wrapper__hd__title">Partnerships</p>
                </div>
                <div class="c--sitemap-a__wrapper__bd">
                    <div class="c--sitemap-a__wrapper__bd__item">
                        <a href="<?php echo home_url(); ?>/partnerships/alteryx/" class="c--sitemap-a__wrapper__bd__item__content">Alteryx</a>
                    </div>
                    <div class="c--sitemap-a__wrapper__bd__item">
                        <a href="<?php echo home_url(); ?>/partnerships/aws/" class="c--sitemap-a__wrapper__bd__item__content">Amazon Web Services</a>
                    </div>
                    <div class="c--sitemap-a__wrapper__bd__item">
                        <a href="<?php echo home_url(); ?>/partnerships/atlassian/" class="c--sitemap-a__wrapper__bd__item__content">Atlassian</a>
                    </div>
                    <div class="c--sitemap-a__wrapper__bd__item">
                        <a href="<?php echo home_url(); ?>/partnerships/crownpeak/" class="c--sitemap-a__wrapper__bd__item__content">Crownpeak</a>
                    </div>
                    <div class="c--sitemap-a__wrapper__bd__item">
                        <a href="<?php echo home_url(); ?>/partnerships/hudson-mx/" class="c--sitemap-a__wrapper__bd__item__content">Hudson MX</a>
                    </div>
                    <div class="c--sitemap-a__wrapper__bd__item">
                        <a href="<?php echo home_url(); ?>/partnerships/servicenow/" class="c--sitemap-a__wrapper__bd__item__content">ServiceNow</a>
                    </div>
                    <div class="c--sitemap-a__wrapper__bd__item">
                        <a href="<?php echo home_url(); ?>/partnerships/snowflake/" class="c--sitemap-a__wrapper__bd__item__content">Snowflake</a>
                    </div>
                    <div class="c--sitemap-a__wrapper__bd__item">
                        <a href="<?php echo home_url(); ?>/partnerships/studiolabs/" class="c--sitemap-a__wrapper__bd__item__content">StudioLabs</a>
                    </div>
                    <div class="c--sitemap-a__wrapper__bd__item">
                        <a href="<?php echo home_url(); ?>/partnerships/tableau/" class="c--sitemap-a__wrapper__bd__item__content">Tableau</a>
                    </div>
                </div>
            </div>
            <div class="c--sitemap-a__wrapper">
                <div class="c--sitemap-a__wrapper__hd">
                    <a href="<?php echo home_url(); ?>/contact/" class="c--sitemap-a__wrapper__hd__title">Talk to Us</a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php get_footer() ?>