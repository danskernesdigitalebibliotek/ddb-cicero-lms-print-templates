<?php
/**
 *  @file       template.php
 *  @brief      Building FBS template from model 
 *  
 *  @details    Converting models from documentation 
 *              ("Opsætning og tilpasning af udskrifter Cicero LMS.pdf") to JSON templates
 *  @copyright  http://www.gnu.org/licenses/lgpl.txt LGPL version 3
 *  @author     Erik Bachmann <ErikBachmann@ClicketyClick.dk>
 *  @since      2020-11-13T14:41:07
 *  @version    2020-11-16T08:49:28
 */

$arr		= [];
$parr		= &$arr;
$fullarr	= [];
$datafile	= 1 < $argc ? $argv[1] : "data.txt";

fputs( STDERR, "datafile [$datafile] $argc\n");

$data		= file_get_contents($datafile);
$data		= str_replace( "\r", "", $data );	// Trim CR
$data		= explode("\n", $data );

//----------------------------------------------------------------------

foreach( $data as $line ) {
	if (strpos($line, "#") === 0) {
		printf( "<#-- %s -->\n", $line );
		continue;	// Skip comments #
	}
	if (strpos($line, "data.") === 0) {
		$fullarr	= array_merge_recursive($fullarr, $arr);
		$arr	= [];
		$parr	= &$arr;
		foreach( explode( '.',  $line ) as $key ) {
			$parr[$key]	= false;
			$parr	= &$parr[$key];
		}
	} else {
		if ( empty( $arr ) ) {
			fputs( STDERR, "Note: $line\n" );
			printf( "<#-- # %s -->\n", $line );	Lines from header without key
		} else
			$parr	.= "$line ";
	}
}
$fullarr	= array_merge_recursive($fullarr, $arr);


//print_r( $fullarr ); exit;
//var_export( $fullarr ); exit;
//echo json_encode( $fullarr, JSON_PRETTY_PRINT );

$depth	= 0;
$stack	= [];
echo "{\n";		// Data header
buildTemplateJson( $fullarr, $depth );
echo "\n}\n";	// Data footer

//----------------------------------------------------------------------

/**
 *  @fn         buildTemplateJson
 *  @brief      Build template from hash
 *  
 *  @details    Looping through structure and build template
 *  
 *  @param [in] $fullarr 	Description for $fullarr
 *  @param [in] $depth 	Description for $depth
 *  @return     Return description
 *  
 *  @example    buildTemplateJson( );
 *  
 *  @todo       
 *  @bug        
 *  @warning    
 *  
 *  @see        
 *  @since      2020-11-13T14:43:15
 */
function buildTemplateJson( $fullarr, &$depth ) {
	global $stack;
	$count	= 0;
	$depth++;
	foreach ( $fullarr as $key => $values ) {//
		array_push ( $stack, $key );

		if ( $key && $count++)
			echo ",\n";

		if ($key) {
			echo str_repeat( "\t", $depth );
			echo "\"$key\": ";
		}
		
		if ( isset( $fullarr[$key] ) ) {
			if ( is_array( $fullarr[$key] ) ) {
				//echo str_repeat( ".", $depth );
				echo "{\n";
				buildTemplateJson( $values, $depth );
				echo "\n";
				echo str_repeat( "\t", $depth );
				echo "}";
			} else {
				if ($key) echo  "\"\${(" . implode( ".", $stack ) . ")!\"\"}\"";
			}
		}
		array_pop( $stack );
	}
	$depth--;
}	// buildTemplateJson()

?>