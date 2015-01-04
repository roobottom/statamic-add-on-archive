<?php

class Plugin_archive extends Plugin
{
  
  public function years()
  {
    $folder_params = $this->fetchParam("folders");
    $month_filter_params = $this->fetchParam("month_filter");
    $folders = $this->cleanFoldersList($folder_params);
    $filenames = $this->scanDirectory($folders);
    
    //filter on month
    if(isset($month_filter_params)) 
    {
		if(strpos($month_filter_params, '-') !== false) {
          list($y, $m, $d) = explode("-", $month_filter_params);
          if(checkdate($m, $d, $y)){
            $target_date = Date::format('m', $month_filter_params);
          }
        } else {
	      echo $month_filter_params;
          $target_date = $month_filter_params;
        }    
	}
    
    //extract all years from all filenames
    foreach($filenames as $file) 
    {
	  $year = substr($file, 0,4);
	  $month = substr($file,5,2);
	  
	  if(isset($target_date)) 
	  {
	    
	    if($month == $target_date)
		{
			$years_array[] = $year;
	    }
	    
	  } 
	  else 
	  {
	  	$years_array[] = $year;
      }
    } 
    
    //get unique year entries and counts.
    $years = array_unique($years_array);
    rsort($years);
    $counts = array_count_values($years_array);
    $total = array_sum($counts);
    
    $return_array['total'] = $total + 1;//it's 0 based!
    //create return array
    foreach($years as $year)
    {
	  if(is_numeric($year)) { //prevent hidden entries from being returned.
	      $return_array['years'][] = array(
	        'year'=>$year,
	        'count'=>$counts[$year]
	      );
      }
    }
    
    return $return_array;
  }
  
  public function months() //get all posts, split by month, for a specific year
  {
    $folder_params = $this->fetchParam("folders");
    $year_params = $this->fetchParam("year");
    $folders = $this->cleanFoldersList($folder_params);
    $filenames = $this->scanDirectory($folders);
    
    
    //extract all years from all filenames
    foreach($filenames as $file) {
      $year = substr($file, 0,4);
      $month = substr($file,5,2);
      if($year == $year_params)
      {
        $months_array[] = $month;
      }
    }
    //get unique year entries and counts.
    $months = array_unique($months_array);
    rsort($months);
    $counts = array_count_values($months_array);
    $total = array_sum($counts);
    
    $return_array['total'] = $total + 1;//it's 0 based!
    //create return array
    foreach($months as $month)
    {
      $return_array['months'][] = array(
        'month'=>$month,
        'month_text'=>date('F', mktime(0, 0, 0, $month, 10)),
        'year'=>$year_params,
        'count'=>$counts[$month],
        'days_in_month'=>cal_days_in_month(CAL_GREGORIAN, $month, $year_params)
      );
    }
    
    return $return_array;
  }
  
  public function monthName() //get the full month text name from a month int.
  {
    $month_params = $this->fetchParam("month") + 0;
    return date('F', mktime(0, 0, 0, $month_params, 10)); // eg, 'March'
  }
  
  /*
  Private functions
  */
  
  function scanDirectory($folders) 
  {
    foreach($folders as $folder) 
    {
      $directory = $_SERVER['DOCUMENT_ROOT'].$folder;
      $dh  = opendir($directory);
      while (false !== ($filename = readdir($dh))) 
      {
        $ext = substr($filename, strrpos($filename, '.') + 1);
        if($ext == "md" && $filename != "page.md")
        {
          $filenames[] = $filename;
        }
        
      }  
    }
    return $filenames;
  }
  
  function cleanFoldersList($folder_params) 
  {
    $folder_params_array = Helper::explodeOptions($folder_params,false);
    foreach($folder_params_array as $part) {
      $folders[] = '/_content'.Path::resolve($part).'/';
    }
    return $folders;
  }
  
}