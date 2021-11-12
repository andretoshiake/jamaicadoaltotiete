<div class="container">
    <div id="jat-search-input">
        <form action="<?php echo home_url('/'); ?>" method="get">
            <fieldset>
                <div class="input-group col-md-12">
                    <input type="text" name="s" id="search" class="search-query form-control" placeholder="<?php _e('Pesquisar', 'jat'); ?>" value="<?php the_search_query(); ?>" />
                    <span class="input-group-btn">
                        <button class="btn btn-success" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </span>
                </div>
            </fieldset>
        </form>
    </div>
</div>