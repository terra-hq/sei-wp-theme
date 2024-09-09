<section class="<?= get_spacing($module['section_spacing']); ?>">
     <div class="f--container">
         <div class="f--row u--justify-content-center">
             <div class="f--col-10 f--col-tablets-12">
              <?php $title = '';
                    $headings = $module['heading'];
                    if ($headings) {
                        foreach ($headings as $heading) {
                            $sentence = $heading['sentence'];
                            $italic = $heading['italic'];
                            if ($italic) {
                                $title .= '<span class="u--font-style-italic">' . esc_html($sentence) . '</span> ';
                            } else {
                                $title .= esc_html($sentence) . ' ';
                            }
                        }
                    } ?>
                <h2 class="f--font-b f--color-a u--text-center"><?php echo $title ?></h2>
             </div>
         </div>
     </div>
 </section>