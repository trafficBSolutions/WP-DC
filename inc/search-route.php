<?php

function  dcResults($data) {
    $mainQuery = new WP_QUERY(array(
        'post_type' => array('post', 'page', 'portfolio', 'company', 'event'),
        's' => sanitize_text_field($data['term'])
    ));

    $results = array(
        'genInfo' => array(),
        'ports' => array(),
        'companies' => array(),
        'events' => array()
    );

    while($mainQuery->have_posts()) {
        $mainQuery->the_post();
        if(get_post_type() == 'post' OR get_post_type() == 'page'){
            array_push($results['genInfo'], array(
                'title' => get_the_title(),
                'url' => get_the_permalink(),
                'postType' => get_post_type(),
                'author' => get_the_author()
            ));
        }
        
        if(get_post_type() == 'portfolio'){
            array_push($results['ports'], array(
                'title' => get_the_title(),
                'url' => get_the_permalink(),
                'id' => get_the_id(),
                'image' => get_the_post_thumbnail_url(0, 'dcLandscape')
            ));
        }
        
        if(get_post_type() == 'company'){
            array_push($results['companies'], array(
                'title' => get_the_title(),
                'url' => get_the_permalink(),
                'image' => get_the_post_thumbnail_url(0, 'dcLandscape')
            ));
        }

        if(get_post_type() == 'event'){
            $eventDate = new DateTime(get_field('event_date'));
            $description = null;
            if(has_excerpt()) {
                $description = get_the_excerpt();
              } else{
                $description = wp_trim_words(get_the_content(), 18);
              }
            array_push($results['events'], array(
                'title' => get_the_title(),
                'url' => get_the_permalink(),
                'month' => $eventDate->format('M'),
                'day' => $eventDate->format('d'),
                'description' => $description
            ));
        }
    }


    if($results['ports']) {
        $metaQuery = array('relation' => 'OR');

        foreach($results['ports'] as $item) {
            array_push($metaQuery, array(
                'key' => 'company_port',
                'compare' => 'LIKE',
                'value' => '"' . $item['id'] . '"'
            ));
        }
        
        $companyRelation = new WP_QUERY(array(
            'post_type' => array('portfolio', 'event'),
            'meta_query' => $metaQuery
                ));
    
        while($companyRelation->have_posts()) {
            $companyRelation->have_posts();
    
            if(get_post_type() == 'event'){
                $eventDate = new DateTime(get_field('event_date'));
                $description = null;
                if(has_excerpt()) {
                    $description = get_the_excerpt();
                  } else{
                    $description = wp_trim_words(get_the_content(), 18);
                  }
                array_push($results['events'], array(
                    'title' => get_the_title(),
                    'url' => get_the_permalink(),
                    'month' => $eventDate->format('M'),
                    'day' => $eventDate->format('d'),
                    'description' => $description
                ));
            }

            if(get_post_type() == 'portfolio'){
                array_push($results['ports'], array(
                    'title' => get_the_title(),
                    'url' => get_the_permalink(),
                    'image' => get_the_post_thumbnail_url(0, 'dcLandscape')
                ));
            }
        }
    
        $results['ports'] = array_values(array_unique($results['ports'], SORT_REGULAR));
        $results['events'] = array_values(array_unique($results['events'], SORT_REGULAR));
    }
    

    return $results;
}

function dcSearch($data) {
    register_rest_route('dc/v1', 'search', array(
        'methods' => WP_REST_SERVER::READABLE,
        'callback' => 'dcResults'
    ));
}

add_action('rest_api_init', 'dcSearch');
?>