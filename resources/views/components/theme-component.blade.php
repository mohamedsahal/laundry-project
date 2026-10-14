<style>
    @php
        $settings = new \App\Models\MasterSettings();
        $site = $settings->siteData();
        $selected_theme = (isset($site['admin_panel_theme']) && !empty($site['admin_panel_theme'])) ? $site['admin_panel_theme'] : 'default';
        $theme = "
            :root{
                --laundry-primary : #0283FF;
                --primary-100 : #BFDCFF;
                --primary-50 : #BFDCFF;
                --laundry-primary-border : #486CEA;
                --laundry-primary-active : #486CEA;
                --laundry-primary-active-border : #8252E9;
                --laundry-btn-hover-color : #FFFFFF;
                --primary-600 : #0283FF;
                --bs-primary-rgb : #0283FF;
            }
        ";
        if($selected_theme == 'red')
        {
            $theme = "
                :root{
                    --laundry-primary : #DC2626;
                    --primary-100 : #FECACA;
                    --primary-50 : #FECACA;
                    --laundry-primary-border : #DC2626;
                    --laundry-primary-active : #B91C1C;
                    --laundry-primary-hover : #DC2626;
                    --laundry-primary-active-border : #DC2626;
                    --primary-600 : #DC2626;
                    --bs-primary-rgb : #DC2626;
                    --laundry-btn-hover-color : #FFFFFF;
                }

                
            ";
        }
        if($selected_theme == 'magenta')
        {
            $theme = "
                :root{
                    --laundry-primary : #8252E9;
                    --laundry-primary-hover : #8252E9;
                    --laundry-primary-border : #8252E9;
                    --laundry-primary-active : #6f37e6;
                    --laundry-primary-active-border : #8252E9;
                    --primary-100 :#EBD7FF;
                    --primary-50 :#EBD7FF;
                    --primary-600 : #8252E9;
                    --bs-primary-rgb : #8252E9;
                    --laundry-btn-hover-color : #FFFFFF;
                }

             
            ";
        }
        if($selected_theme == 'orange')
        {
            $theme = "
                :root{
                    --laundry-primary : #FF9F29;
                    --laundry-primary-hover : #FF9F29;
                    --laundry-primary-border : #FF9F29;
                    --laundry-primary-active : #f39016;
                    --laundry-primary-active-border : #FF9F29;
                    --primary-100 :#FEF9C3;
                    --primary-50 :#FEF9C3;
                    --primary-600 : #FF9F29;
                    --bs-primary-rgb : #FF9F29;
                    --laundry-btn-hover-color : #FFFFFF;
                }

              
            ";
        }
        if($selected_theme == 'green')
        {
            $theme = "
                :root{
                    --laundry-primary : #16A34A;
                    --primary-100 : #DCFCE7;
                    --primary-50 : #DCFCE7;
                    --laundry-primary-border : #16A34A;
                    --laundry-primary-active : #15803D;
                    --laundry-primary-active-border : #8252E9;
                    --primary-600 : #16A34A;
                    --bs-primary-rgb : 22, 163, 74;
                    --laundry-btn-hover-color : #FFFFFF;
                }
               
               
            ";
        }
        if($selected_theme == 'blueDark')
        {
            $theme = "
                :root{
                    --laundry-primary : #2563EB;
                    --primary-100 : #BFDBFE;
                    --primary-50 : #BFDBFE;
                    --laundry-primary-border : #2563EB;
                    --laundry-primary-active : #1D4ED8;
                    --laundry-primary-active-border : #1D4ED8;
                    --primary-600 : #2563EB;
                    --bs-primary-rgb : 22, 163, 74;
                    --laundry-btn-hover-color : #FFFFFF;
                }

               
            ";
        }
        @endphp
    {{$theme}}

    .btn-primary:hover{
        background-color: var(--laundry-primary-active)!important;
        color: var(--laundry-btn-hover-color)!important;
    }

    .text-primary{
        color: var(--laundry-primary)!important;
    }

    .text-primary-light{
    }

    .btn-primary-600:hover{
        background-color: var(--laundry-primary-active)!important;
        border-color: var(--laundry-primary-border)!important;
        color: var(--laundry-btn-hover-color)!important;
    }
</style>