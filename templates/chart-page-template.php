<?php /* Template Name: Chart.JS */ ?>
<?php get_header(); ?>

	<div id="primary" class="featured-content content-area">
		<main id="main" class="site-main">

            <?php while ( have_posts() ) : the_post(); ?>

            <div id="loop-container" class="loop-container">
                <div class="page type-page status-publish hentry entry">
                    <article class="posts-entry fbox page type-page status-publish hentry">
                        <div class="post-container">
                        <div class="post-header">
                            <h1 class="post-title"><?php the_title(); ?></h1>
                        </div>
                        <div class="post-content"> <?php
                        $postid = get_the_ID();
                        $post_chart_type = get_post_meta($postid, "meta_chart_type", true);
                        $meta_chart_name = get_post_meta($postid, "meta_chart_name", true);
                        $get_meta_chart_data = get_post_meta($postid, "meta_chart_data", true);
                        $column_name = get_post_meta($postid, "meta_chart_column_name", true);
                        $column_color = get_post_meta($postid, "meta_chart_column_color", true);
                        $i = 0;

                        echo '<canvas id="canvas" data-chartid="' . $postid . '" data-chart-type="' . $post_chart_type .'"></canvas>';
                        
                        echo '<table>';
                        echo '<tr>';
                        echo '<th>';
                        echo '</th>';
                        foreach ($meta_chart_name as $chart_name) {
                            echo '<th>';
                            echo $chart_name;
                            echo '</th>';
                        }
                        echo '</tr>';
                        foreach ($get_meta_chart_data as $meta_chart_data) {
                            echo '<tr>';
                            echo '<td>';
                                echo $column_name[$i];
                            echo '</td>';
                            $y = 0;
                            foreach ($meta_chart_data as $meta_chart_value) {
                                echo '<td>';
                                echo $meta_chart_value;
                                echo '</td>';
                                $y++;
                            }
                            echo '</tr>';
                            $i++;
                        }
                        echo '</table>'; ?>
                        </div>
                    </article>
                </div>
            </div>
            <?php endwhile; // end of the loop. ?>
			
        </main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();