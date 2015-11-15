<?php
/**
 * @file
 * Contains the theme's functions to manipulate Drupal's default markup.
 *
 * Complete documentation for this file is available online.
 * @see https://drupal.org/node/1728096
 */


/**
 * Override or insert variables into the maintenance page template.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("maintenance_page" in this case.)
 */
/* -- Delete this line if you want to use this function
function elle_preprocess_maintenance_page(&$variables, $hook) {
  // When a variable is manipulated or added in preprocess_html or
  // preprocess_page, that same work is probably needed for the maintenance page
  // as well, so we can just re-use those functions to do that work here.
  elle_preprocess_html($variables, $hook);
  elle_preprocess_page($variables, $hook);
}
// */

/**
 * Override or insert variables into the html templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("html" in this case.)
 */

function elle_preprocess_html(&$variables, $hook) {

  //variable initial

  $machine_name='';
  $tid='';
  $channel='';
  $eng_title='';
  $publish_time='';
  $author='';
  $current_term_eng='';
  $keyword='';
  $type='';
  $content_id='';
  //Add ELLE Custom MetaTag on node page
  if (arg(0) == 'node' && is_numeric(arg(1))){
    $content_id=arg(1);
    $node=node_load(arg(1));
    $machine_name= isset($node->type) ? $node->type : NULL;
    switch($machine_name){
      case 'article':
        $type='new_dossier';
        $tid=$node->field_folder_taxonomy['und'][0]['target_id'];
        $eng_title = isset($node->field_english_title['und'][0]['value']) ? $node->field_english_title['und'][0]['value'] : NULL;
        $author=$node->name;
        $parent=taxonomy_get_parents($tid);
        $current_term=taxonomy_term_load($tid);
        $current_term_eng=isset($current_term->field_eng_name['und'][0]['value']) ? $current_term->field_eng_name['und'][0]['value'] : NULL ;
        if(isset($node->field_tags['und'][0]['tid'])){
          $array=$node->field_tags['und'];
          foreach($array as $key => $value){
            $tid=$value['tid'];
            $term_name=taxonomy_term_load($tid)->name;
            $keyword=$keyword.$term_name.', ';
          }
        }
        $publish_time=Date('Y-m-d H:i:s',$node->created);
        foreach($parent as $key => $value){
          $channel=isset($value->field_eng_name['und'][0]['value']) ? $value->field_eng_name['und'][0]['value'] : NULL;
        }
        break;
      case 'free_article':
        $type='free_article';
        $tid=$node->field_folder_taxonomy['und'][0]['target_id'];
        $eng_title = isset($node->field_english_title['und'][0]['value']) ? $node->field_english_title['und'][0]['value'] : NULL;
        $author=$node->name;
        $parent=taxonomy_get_parents($tid);
        $current_term=taxonomy_term_load($tid);
        $current_term_eng=isset($current_term->field_eng_name['und'][0]['value']) ? $current_term->field_eng_name['und'][0]['value'] : NULL ;
        if(isset($node->field_tags['und'][0]['tid'])){
          $array=$node->field_tags['und'];
          foreach($array as $key => $value){
            $tid=$value['tid'];
            $term_name=taxonomy_term_load($tid)->name;
            $keyword=$keyword.$term_name.', ';
          }
        }
        $publish_time=Date('Y-m-d H:i:s',$node->created);
        foreach($parent as $key => $value){
          $channel=isset($value->field_eng_name['und'][0]['value']) ? $value->field_eng_name['und'][0]['value'] : NULL;
        }

        break;
      default:
        $type=$machine_name;
    }
  }
  elseif(arg(0)=='taxonomy' && arg(1)=='term' && is_numeric(arg(2))){ //頻道頁面ELLE Data Tag
    $tid=arg(2);
    $content_id=arg(2);
    $parent=taxonomy_get_parents($tid);
    $current_term=taxonomy_term_load($tid);
    $current_term_eng=isset($current_term->field_eng_name['und'][0]['value']) ? $current_term->field_eng_name['und'][0]['value'] : NULL ;
    $keyword=isset($current_term->metatags['und']['keywords']['value']) ? $current_term->metatags['und']['keywords']['value'] : NULL;
    if($parent){

      foreach($parent as $key => $value){
        $channel=isset($value->field_eng_name['und'][0]['value']) ? $value->field_eng_name['und'][0]['value'] : NULL;
      }
    }
    else{
      $channel=isset($current_term->field_eng_name['und'][0]['value']) ? $current_term->field_eng_name['und'][0]['value'] : NULL;
    }

  }

  $html_head = array(
    'data_type' => array(
      '#type'=>'html_tag',
      '#tag' => 'meta',
      '#attributes' => array(
        'property' => 'data-type',
        'content' => $type,
      )
    ),
    'data_title' => array(
      '#type'=>'html_tag',
      '#tag' => 'meta',
      '#attributes' => array(
        'property' => 'data-title',
        'content' => $variables['head_title'],
      )
    ),
    'data_pageName' => array(
      '#type'=>'html_tag',
      '#tag' => 'meta',
      '#attributes' => array(
        'property' => 'data-pageName',
        'content' => $channel.':'.$current_term_eng.':'.$eng_title,
      )
    ),
    'data_channel' => array(
      '#type'=>'html_tag',
      '#tag' => 'meta',
      '#attributes' => array(
        'property' => 'data-channel',
        'content' => $channel,
      )
    ),
    'data_internalsearch' => array(
      '#type'=>'html_tag',
      '#tag' => 'meta',
      '#attributes' => array(
        'property' => 'data-internalsearch',
        'content' => $keyword,
      )
    ),
    'published_time' => array(
      '#type'=>'html_tag',
      '#tag' => 'meta',
      '#attributes' => array(
        'property' => 'data-article:published_time',
        'content' => $publish_time,
      )
    ),
    'data_contentId' => array(
      '#type'=>'html_tag',
      '#tag' => 'meta',
      '#attributes' => array(
        'property' => 'data-contentId',
        'content' => $content_id,
      )
    ),
    'data_author' => array(
      '#type'=>'html_tag',
      '#tag' => 'meta',
      '#attributes' => array(
        'property' => 'data-author',
        'content' => $author,
      )
    ),
    'data_siteheir' => array(
      '#type'=>'html_tag',
      '#tag' => 'meta',
      '#attributes' => array(
        'property' => 'data-siteHeir',
        'content' => $channel.','.$current_term_eng.','.$eng_title,
      )
    ),
  );
  foreach ($html_head as $key => $data) {
    drupal_add_html_head($data, $key);
  }

}
// */

/**
 * Override or insert variables into the page templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("page" in this case.)
 */
/* -- Delete this line if you want to use this function
function elle_preprocess_page(&$variables, $hook) {
  $variables['sample_variable'] = t('Lorem ipsum.');
}
// */

/**
 * Override or insert variables into the node templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("node" in this case.)
 */

function elle_preprocess_node(&$variables, $hook) {
  if ($variables['node']->type == 'article' or $variables['node']->type == 'free_article') {
    $theme_path = drupal_get_path('theme', 'elle');
    drupal_add_js($theme_path . '/js/afterChange.js');
  }
}
// */

/**
 * Override or insert variables into the comment templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("comment" in this case.)
 */
/* -- Delete this line if you want to use this function
function elle_preprocess_comment(&$variables, $hook) {
  $variables['sample_variable'] = t('Lorem ipsum.');
}
// */

/**
 * Override or insert variables into the region templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("region" in this case.)
 */
/* -- Delete this line if you want to use this function
function elle_preprocess_region(&$variables, $hook) {
  // Don't use Zen's region--sidebar.tpl.php template for sidebars.
  //if (strpos($variables['region'], 'sidebar_') === 0) {
  //  $variables['theme_hook_suggestions'] = array_diff($variables['theme_hook_suggestions'], array('region__sidebar'));
  //}
}
// */

/**
 * Override or insert variables into the block templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("block" in this case.)
 */

function elle_preprocess_block(&$variables, $hook) {
  
  if ($variables['elements']['#block']->module== 'nodeblock') {
      //dpm($variables);
      $variables['elements']['#block']->subject = NULL;
  }
}

