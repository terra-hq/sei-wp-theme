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
<section class="f--pb-15 f--pb-tablets-10">
    <div class="f--container">
        <div class="f--row f--gap-a">
            <div class="f--col-3 f--col-tabletm-4 f--col-tablets-12">
                <p class="f--font-f">About SEI</p>
            </div>
            <div class="f--col-9 f--col-tabletm-8 f--col-tablets-12">
                <div class="f--row f--gap-d">
                    <div class="f--col-4 f--col-tabletl-6 f--col-mobile-12">
                        <p class="f--font-h u--font-light"><a href="<?php echo home_url(); ?>/about/about-sei/" class="g--link-01 g--link-01--second">About Us</a></p>
                    </div>
                    <div class="f--col-4 f--col-tabletl-6 f--col-mobile-12">
                        <p class="f--font-h u--font-light"><a href="<?php echo home_url(); ?>/about/awards-and-recognition/" class="g--link-01 g--link-01--second">Awards & Recognition</a></p>
                    </div>
                    <div class="f--col-4 f--col-tabletl-6 f--col-mobile-12">
                        <p class="f--font-h u--font-light"><a href="<?php echo home_url(); ?>/about/leadership/" class="g--link-01 g--link-01--second">Leadership Team</a></p>
                    </div>
                    <div class="f--col-4 f--col-tabletl-6 f--col-mobile-12">
                        <p class="f--font-h u--font-light"><a href="<?php echo home_url(); ?>/about/newsroom/" class="g--link-01 g--link-01--second">Newsroom</a></p>
                    </div>
                </div>
            </div>
            <div class="f--col-12">
                <hr class="c--border-a f--mb-8 f--mb-tablets-5">
            </div>
        </div>
        <div class="f--row f--gap-a">
            <div class="f--col-3 f--col-tabletm-4 f--col-tablets-12">
                <p class="f--font-f">Careers</p>
            </div>
            <div class="f--col-9 f--col-tabletm-8 f--col-tablets-12">
                <div class="f--row f--gap-d">
                    <div class="f--col-4 f--col-tabletl-6 f--col-mobile-12">
                        <p class="f--font-h u--font-light"><a href="<?php echo home_url(); ?>/careers/" class="g--link-01 g--link-01--second">Careers</a></p>
                    </div>
                    <div class="f--col-4 f--col-tabletl-6 f--col-mobile-12">
                        <p class="f--font-h u--font-light"><a href="<?php echo home_url(); ?>/careers/open-positions/" class="g--link-01 g--link-01--second">Open Positions</a></p>
                    </div>
                </div>
            </div>
            <div class="f--col-12">
                <hr class="c--border-a f--mb-8 f--mb-tablets-5">
            </div>
        </div>
        <div class="f--row f--gap-a">
            <div class="f--col-3 f--col-tabletm-4 f--col-tablets-12">
                <a href="<?php echo home_url(); ?>/capabilities/" class="f--font-f g--link-01">Capabilities</a>
            </div>
            <div class="f--col-9 f--col-tabletm-8 f--col-tablets-12 f--gap-d">
                <div class="f--row f--gap-c">
                    <div class="f--col-4 f--col-tabletl-6 f--col-mobile-12 u--display-flex u--flex-direction-column f--gap-d">
                        <p class="f--font-g"><a href="<?php echo home_url(); ?>/capabilities/ai-technology/" class="g--link-01">AI & Technology</a></p>
                        <p class="f--font-h u--font-light"><a href="<?php echo home_url(); ?>/capabilities/ai-technology/agile-transformation/" class="g--link-01 g--link-01--second">Agile Transformation</a></p>
                        <p class="f--font-h u--font-light"><a href="<?php echo home_url(); ?>/capabilities/ai-technology/application-development/" class="g--link-01 g--link-01--second">Application Development</a></p>
                        <p class="f--font-h u--font-light"><a href="<?php echo home_url(); ?>/capabilities/ai-technology/cloud-technology-strategies/" class="g--link-01 g--link-01--second">Cloud & Technology Strategies</a></p>
                        <p class="f--font-h u--font-light"><a href="<?php echo home_url(); ?>/capabilities/ai-technology/devops/" class="g--link-01 g--link-01--second">Dev Ops</a></p>
                        <p class="f--font-h u--font-light"><a href="<?php echo home_url(); ?>/capabilities/ai-technology/solution-design/" class="g--link-01 g--link-01--second">Solution Design</a></p>
                    </div>
                    <div class="f--col-4 f--col-tabletl-6 f--col-mobile-12 u--display-flex u--flex-direction-column f--gap-d">
                        <p class="f--font-g"><a href="<?php echo home_url(); ?>/capabilities/concept-to-delivery/" class="g--link-01">Concept to Delivery</a></p>
                        <p class="f--font-h u--font-light"><a href="<?php echo home_url(); ?>/capabilities/concept-to-delivery/change-management/" class="g--link-01 g--link-01--second">Change Management</a></p>
                        <p class="f--font-h u--font-light"><a href="<?php echo home_url(); ?>/capabilities/concept-to-delivery/design-thinking/" class="g--link-01 g--link-01--second">Design Thinking</a></p>
                        <p class="f--font-h u--font-light"><a href="<?php echo home_url(); ?>/capabilities/concept-to-delivery/product-management/" class="g--link-01 g--link-01--second">Product Management</a></p>
                        <p class="f--font-h u--font-light"><a href="<?php echo home_url(); ?>/capabilities/concept-to-delivery/rapid-prototyping/" class="g--link-01 g--link-01--second">Rapid Prototyping</a></p>
                        <p class="f--font-h u--font-light"><a href="<?php echo home_url(); ?>/capabilities/concept-to-delivery/solution-delivery/" class="g--link-01 g--link-01--second">Solution Delivery</a></p>
                    </div>
                    <div class="f--col-4 f--col-tabletl-6 f--col-mobile-12 u--display-flex u--flex-direction-column f--gap-d">
                        <p class="f--font-g"><a href="<?php echo home_url(); ?>/capabilities/data-and-analytics/" class="g--link-01">Data & Analytics</a></p>
                        <p class="f--font-h u--font-light"><a href="<?php echo home_url(); ?>/capabilities/data-and-analytics/advanced-analytics/" class="g--link-01 g--link-01--second">Advanced Analytics</a></p>
                        <p class="f--font-h u--font-light"><a href="<?php echo home_url(); ?>/capabilities/data-and-analytics/data-governance/" class="g--link-01 g--link-01--second">Data Governance</a></p>
                        <p class="f--font-h u--font-light"><a href="<?php echo home_url(); ?>/capabilities/data-and-analytics/data-modernization/" class="g--link-01 g--link-01--second">Data Modernization</a></p>
                        <p class="f--font-h u--font-light"><a href="<?php echo home_url(); ?>/capabilities/data-and-analytics/data-strategy/" class="g--link-01 g--link-01--second">Data Strategy</a></p>
                        <p class="f--font-h u--font-light"><a href="<?php echo home_url(); ?>/capabilities/data-and-analytics/data-visualization/" class="g--link-01 g--link-01--second">Data Visualization</a></p>
                    </div>
                    <div class="f--col-4 f--col-tabletl-6 f--col-mobile-12 u--display-flex u--flex-direction-column f--gap-d">
                        <p class="f--font-g"><a href="<?php echo home_url(); ?>/capabilities/security-risk-and-compliance/" class="g--link-01">Security, Risk & Compliance</a></p>
                        <p class="f--font-h u--font-light"><a href="<?php echo home_url(); ?>/capabilities/security-risk-and-compliance/compliance/" class="g--link-01 g--link-01--second">Compliance</a></p>
                        <p class="f--font-h u--font-light"><a href="<?php echo home_url(); ?>/capabilities/security-risk-and-compliance/data-privacy/" class="g--link-01 g--link-01--second">Data Privacy</a></p>
                        <p class="f--font-h u--font-light"><a href="<?php echo home_url(); ?>/capabilities/security-risk-and-compliance/information-security/" class="g--link-01 g--link-01--second">Information Security</a></p>
                        <p class="f--font-h u--font-light"><a href="<?php echo home_url(); ?>/capabilities/security-risk-and-compliance/risk-management/" class="g--link-01 g--link-01--second">Risk Management</a></p>
                    </div>
                    <div class="f--col-4 f--col-tabletl-6 f--col-mobile-12 u--display-flex u--flex-direction-column f--gap-d">
                        <p class="f--font-g"><a href="<?php echo home_url(); ?>/capabilities/strategy-and-operations/" class="g--link-01">Strategy & Operations</a></p>
                        <p class="f--font-h u--font-light"><a href="<?php echo home_url(); ?>/capabilities/strategy-and-operations/mergers-acquisitions/" class="g--link-01 g--link-01--second">Mergers & Acquisitions</a></p>
                        <p class="f--font-h u--font-light"><a href="<?php echo home_url(); ?>/capabilities/strategy-and-operations/operational-transformation/" class="g--link-01 g--link-01--second">Operational Transformation</a></p>
                        <p class="f--font-h u--font-light"><a href="<?php echo home_url(); ?>/capabilities/strategy-and-operations/organizational-design/" class="g--link-01 g--link-01--second">Organization Design</a></p>
                        <p class="f--font-h u--font-light"><a href="<?php echo home_url(); ?>/capabilities/strategy-and-operations/process-improvement/" class="g--link-01 g--link-01--second">Process Improvement</a></p>
                        <p class="f--font-h u--font-light"><a href="<?php echo home_url(); ?>/capabilities/strategy-and-operations/strategy-execution/" class="g--link-01 g--link-01--second">Strategy & Execution</a></p>
                    </div>
                </div>
            </div>
            <div class="f--col-12">
                <hr class="c--border-a f--mb-8 f--mb-tablets-5">
            </div>
        </div>
        <div class="f--row f--gap-a">
            <div class="f--col-3 f--col-tabletm-4 f--col-tablets-12">
                <a href="<?php echo home_url(); ?>/functions/" class="f--font-f g--link-01">Functions</a>
            </div>
            <div class="f--col-12">
                <hr class="c--border-a f--mb-8 f--mb-tablets-5">
            </div>
        </div>
        <div class="f--row f--gap-a">
            <div class="f--col-3 f--col-tabletm-4 f--col-tablets-12">
                <a href="<?php echo home_url(); ?>/industries/" class="f--font-f g--link-01">Industries</a>
            </div>
            <div class="f--col-9 f--col-tabletm-8 f--col-tablets-12">
                <div class="f--row f--gap-d">
                    <div class="f--col-4 f--col-tabletl-6 f--col-mobile-12">
                        <p class="f--font-h u--font-light"><a href="<?php echo home_url(); ?>/industries/automotive-transportation/" class="g--link-01 g--link-01--second">Automotive & Transportation</a></p>
                    </div>
                    <div class="f--col-4 f--col-tabletl-6 f--col-mobile-12">
                        <p class="f--font-h u--font-light"><a href="<?php echo home_url(); ?>/industries/construction-and-real-estate/" class="g--link-01 g--link-01--second">Construction & Real Estate</a></p>
                    </div>
                    <div class="f--col-4 f--col-tabletl-6 f--col-mobile-12">
                        <p class="f--font-h u--font-light"><a href="<?php echo home_url(); ?>/industries/consumer-products/" class="g--link-01 g--link-01--second">Consumer Products</a></p>
                    </div>
                    <div class="f--col-4 f--col-tabletl-6 f--col-mobile-12">
                        <p class="f--font-h u--font-light"><a href="<?php echo home_url(); ?>/industries/environmental-services/" class="g--link-01 g--link-01--second">Environmental Services</a></p>
                    </div>
                    <div class="f--col-4 f--col-tabletl-6 f--col-mobile-12">
                        <p class="f--font-h u--font-light"><a href="<?php echo home_url(); ?>/industries/financial-services/" class="g--link-01 g--link-01--second">Financial Services</a></p>
                    </div>
                    <div class="f--col-4 f--col-tabletl-6 f--col-mobile-12">
                        <p class="f--font-h u--font-light"><a href="<?php echo home_url(); ?>/industries/government-services/" class="g--link-01 g--link-01--second">Government Services</a></p>
                    </div>
                    <div class="f--col-4 f--col-tabletl-6 f--col-mobile-12">
                        <p class="f--font-h u--font-light"><a href="<?php echo home_url(); ?>/industries/healthcare/" class="g--link-01 g--link-01--second">Healthcare</a></p>
                    </div>
                    <div class="f--col-4 f--col-tabletl-6 f--col-mobile-12">
                        <p class="f--font-h u--font-light"><a href="<?php echo home_url(); ?>/industries/higher-education/" class="g--link-01 g--link-01--second">Higher Education</a></p>
                    </div>
                    <div class="f--col-4 f--col-tabletl-6 f--col-mobile-12">
                        <p class="f--font-h u--font-light"><a href="<?php echo home_url(); ?>/industries/insurance/" class="g--link-01 g--link-01--second">Insurance</a></p>
                    </div>
                    <div class="f--col-4 f--col-tabletl-6 f--col-mobile-12">
                        <p class="f--font-h u--font-light"><a href="<?php echo home_url(); ?>/industries/leisure-hospitality/" class="g--link-01 g--link-01--second">Leisure & Hospitality</a></p>
                    </div>
                    <div class="f--col-4 f--col-tabletl-6 f--col-mobile-12">
                        <p class="f--font-h u--font-light"><a href="<?php echo home_url(); ?>/industries/life-sciences/" class="g--link-01 g--link-01--second">Life Sciences</a></p>
                    </div>
                    <div class="f--col-4 f--col-tabletl-6 f--col-mobile-12">
                        <p class="f--font-h u--font-light"><a href="<?php echo home_url(); ?>/industries/media-entertainment/" class="g--link-01 g--link-01--second">Media & Entertainment</a></p>
                    </div>
                    <div class="f--col-4 f--col-tabletl-6 f--col-mobile-12">
                        <p class="f--font-h u--font-light"><a href="<?php echo home_url(); ?>/industries/professional-services/" class="g--link-01 g--link-01--second">Professional Services</a></p>
                    </div>
                    <div class="f--col-4 f--col-tabletl-6 f--col-mobile-12">
                        <p class="f--font-h u--font-light"><a href="<?php echo home_url(); ?>/industries/retail-e-commerce/" class="g--link-01 g--link-01--second">Retail & E-Commerce</a></p>
                    </div>
                    <div class="f--col-4 f--col-tabletl-6 f--col-mobile-12">
                        <p class="f--font-h u--font-light"><a href="<?php echo home_url(); ?>/industries/supply-chain/" class="g--link-01 g--link-01--second">Supply Chain</a></p>
                    </div>
                    <div class="f--col-4 f--col-tabletl-6 f--col-mobile-12">
                        <p class="f--font-h u--font-light"><a href="<?php echo home_url(); ?>/industries/utilities/" class="g--link-01 g--link-01--second">Utilities</a></p>
                    </div>
                </div>
            </div>
            <div class="f--col-12">
                <hr class="c--border-a f--mb-8 f--mb-tablets-5">
            </div>
        </div>
        <div class="f--row f--gap-a">
            <div class="f--col-3 f--col-tabletm-4 f--col-tablets-12">
                <a href="<?php echo home_url(); ?>/insights/" class="f--font-f g--link-01">Insights</a>
            </div>
            <div class="f--col-12">
                <hr class="c--border-a f--mb-8 f--mb-tablets-5">
            </div>
        </div>
        <div class="f--row f--gap-a">
            <div class="f--col-3 f--col-tabletm-4 f--col-tablets-12">
                <a href="<?php echo home_url(); ?>/locations/" class="f--font-f g--link-01">Locations</a>
            </div>
            <div class="f--col-9 f--col-tabletm-8 f--col-tablets-12">
                <div class="f--row f--gap-d">
                    <div class="f--col-4 f--col-tabletl-6 f--col-mobile-12">
                        <p class="f--font-h u--font-light"><a href="<?php echo home_url(); ?>/locations/atlanta/" class="g--link-01 g--link-01--second">Atlanta</a></p>
                    </div>
                    <div class="f--col-4 f--col-tabletl-6 f--col-mobile-12">
                        <p class="f--font-h u--font-light"><a href="<?php echo home_url(); ?>/locations/boston/" class="g--link-01 g--link-01--second">Boston</a></p>
                    </div>
                    <div class="f--col-4 f--col-tabletl-6 f--col-mobile-12">
                        <p class="f--font-h u--font-light"><a href="<?php echo home_url(); ?>/locations/charlotte/" class="g--link-01 g--link-01--second">Charlotte</a></p>
                    </div>
                    <div class="f--col-4 f--col-tabletl-6 f--col-mobile-12">
                        <p class="f--font-h u--font-light"><a href="<?php echo home_url(); ?>/locations/chicago/" class="g--link-01 g--link-01--second">Chicago</a></p>
                    </div>
                    <div class="f--col-4 f--col-tabletl-6 f--col-mobile-12">
                        <p class="f--font-h u--font-light"><a href="<?php echo home_url(); ?>/locations/cincinnati/" class="g--link-01 g--link-01--second">Cincinnati</a></p>
                    </div>
                    <div class="f--col-4 f--col-tabletl-6 f--col-mobile-12">
                        <p class="f--font-h u--font-light"><a href="<?php echo home_url(); ?>/locations/dallas/" class="g--link-01 g--link-01--second">Dallas</a></p>
                    </div>
                    <div class="f--col-4 f--col-tabletl-6 f--col-mobile-12">
                        <p class="f--font-h u--font-light"><a href="<?php echo home_url(); ?>/locations/miami/" class="g--link-01 g--link-01--second">Miami</a></p>
                    </div>
                    <div class="f--col-4 f--col-tabletl-6 f--col-mobile-12">
                        <p class="f--font-h u--font-light"><a href="<?php echo home_url(); ?>/locations/nashville/" class="g--link-01 g--link-01--second">Nashville</a></p>
                    </div>
                    <div class="f--col-4 f--col-tabletl-6 f--col-mobile-12">
                        <p class="f--font-h u--font-light"><a href="<?php echo home_url(); ?>/locations/new-york/" class="g--link-01 g--link-01--second">New York</a></p>
                    </div>
                    <div class="f--col-4 f--col-tabletl-6 f--col-mobile-12">
                        <p class="f--font-h u--font-light"><a href="<?php echo home_url(); ?>/locations/philadelphia/" class="g--link-01 g--link-01--second">Philadelphia</a></p>
                    </div>
                    <div class="f--col-4 f--col-tabletl-6 f--col-mobile-12">
                        <p class="f--font-h u--font-light"><a href="<?php echo home_url(); ?>/locations/phoenix/" class="g--link-01 g--link-01--second">Phoenix</a></p>
                    </div>
                    <div class="f--col-4 f--col-tabletl-6 f--col-mobile-12">
                        <p class="f--font-h u--font-light"><a href="<?php echo home_url(); ?>/locations/seattle/" class="g--link-01 g--link-01--second">Seattle</a></p>
                    </div>
                    <div class="f--col-4 f--col-tabletl-6 f--col-mobile-12">
                        <p class="f--font-h u--font-light"><a href="<?php echo home_url(); ?>/locations/shared-services/" class="g--link-01 g--link-01--second">Shared Services</a></p>
                    </div>
                    <div class="f--col-4 f--col-tabletl-6 f--col-mobile-12">
                        <p class="f--font-h u--font-light"><a href="<?php echo home_url(); ?>/locations/washington-dc/" class="g--link-01 g--link-01--second">Washington D.C.</a></p>
                    </div>
                </div>
            </div>
            <div class="f--col-12">
                <hr class="c--border-a f--mb-8 f--mb-tablets-5">
            </div>
        </div>
        <div class="f--row f--gap-a">
            <div class="f--col-3 f--col-tabletm-4 f--col-tablets-12">
                <p class="f--font-f">Partnerships</p>
            </div>
            <div class="f--col-9 f--col-tabletm-8 f--col-tablets-12">
                <div class="f--row f--gap-d">
                    <div class="f--col-4 f--col-tabletl-6 f--col-mobile-12">
                        <p class="f--font-h u--font-light"><a href="<?php echo home_url(); ?>/partnerships/alteryx/" class="g--link-01 g--link-01--second">Alteryx</a></p>
                    </div>
                    <div class="f--col-4 f--col-tabletl-6 f--col-mobile-12">
                        <p class="f--font-h u--font-light"><a href="<?php echo home_url(); ?>/partnerships/aws/" class="g--link-01 g--link-01--second">Amazon Web Services</a></p>
                    </div>
                    <div class="f--col-4 f--col-tabletl-6 f--col-mobile-12">
                        <p class="f--font-h u--font-light"><a href="<?php echo home_url(); ?>/partnerships/atlassian/" class="g--link-01 g--link-01--second">Atlassian</a></p>
                    </div>
                    <div class="f--col-4 f--col-tabletl-6 f--col-mobile-12">
                        <p class="f--font-h u--font-light"><a href="<?php echo home_url(); ?>/partnerships/crownpeak/" class="g--link-01 g--link-01--second">Crownpeak</a></p>
                    </div>
                    <div class="f--col-4 f--col-tabletl-6 f--col-mobile-12">
                        <p class="f--font-h u--font-light"><a href="<?php echo home_url(); ?>/partnerships/hudson-mx/" class="g--link-01 g--link-01--second">Hudson MX</a></p>
                    </div>
                    <div class="f--col-4 f--col-tabletl-6 f--col-mobile-12">
                        <p class="f--font-h u--font-light"><a href="<?php echo home_url(); ?>/partnerships/servicenow/" class="g--link-01 g--link-01--second">ServiceNow</a></p>
                    </div>
                    <div class="f--col-4 f--col-tabletl-6 f--col-mobile-12">
                        <p class="f--font-h u--font-light"><a href="<?php echo home_url(); ?>/partnerships/snowflake/" class="g--link-01 g--link-01--second">Snowflake</a></p>
                    </div>
                    <div class="f--col-4 f--col-tabletl-6 f--col-mobile-12">
                        <p class="f--font-h u--font-light"><a href="<?php echo home_url(); ?>/partnerships/studiolabs/" class="g--link-01 g--link-01--second">StudioLabs</a></p>
                    </div>
                    <div class="f--col-4 f--col-tabletl-6 f--col-mobile-12">
                        <p class="f--font-h u--font-light"><a href="<?php echo home_url(); ?>/partnerships/tableau/" class="g--link-01 g--link-01--second">Tableau</a></p>
                    </div>
                </div>
            </div>
            <div class="f--col-12">
                <hr class="c--border-a f--mb-8 f--mb-tablets-5">
            </div>
        </div>
        <div class="f--row f--gap-a">
            <div class="f--col-3 f--col-tabletm-4 f--col-tablets-12">
                <a href="<?php echo home_url(); ?>/contact/" class="f--font-f g--link-01">Talk to Us</a>
            </div>
        </div>
    </div>
</section>
<?php get_footer() ?>