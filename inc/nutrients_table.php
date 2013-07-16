<?php

/* $nutrients_lookup_table is 2-dimensional associative array with the following layout:
{
	 urn:uuid:a4d01e46-5df2-4cb3-ad2c-6b438e79e5b9 => {
		'description' => "Calories",
		'unit' => "kcal"
	},
	urn:uuid:666ae7df-af65-4d55-8d5f-996e6cc384ca => {
		'description' => "Protein",
		'unit' => "g"
	},

	...
}

Note that the urn:uuid:a4d01e.... keys in the top level of the associative array are the ESHA id's associated with each type of nutrient
*/

$nutrients_lookup_table =  '[{"id":"urn:uuid:a4d01e46-5df2-4cb3-ad2c-6b438e79e5b9","description":"Calories","unit":"kcal"},{"id":"urn:uuid:666ae7df-af65-4d55-8d5f-996e6cc384ca","description":"Protein","unit":"g"},{"id":"urn:uuid:975a8d10-8650-4e0c-9a8f-7f4aaa6ae9e2","description":"Carbohydrates","unit":"g"},{"id":"urn:uuid:7e53326a-e016-4560-ac5a-894c28e5085c","description":"Dietary Fiber","unit":"g"},{"id":"urn:uuid:217d969b-9bad-49d0-b082-07a66c464ec0","description":"Total Sugars","unit":"g"},{"id":"urn:uuid:589294dc-3dcc-4b64-be06-c07e7f65c4bd","description":"Fat","unit":"g"},{"id":"urn:uuid:f763a45c-36d7-4a7a-a656-e2f1384a94e7","description":"Saturated Fat","unit":"g"},{"id":"urn:uuid:9a40b734-b332-4870-b4d8-558f8b812064","description":"Mono Fat","unit":"g"},{"id":"urn:uuid:11708139-c4eb-4036-8ab3-88ccb1068ae0","description":"Poly Fat","unit":"g"},{"id":"urn:uuid:9b31599d-2af1-4bc1-a91f-190989a8345e","description":"Trans Fatty Acid","unit":"g"},{"id":"urn:uuid:bde92a59-1aad-40d8-8abc-1486f17ba5ed","description":"Cholesterol","unit":"mg"},{"id":"urn:uuid:8d229989-2c2c-423c-81a9-47fd235d1aaf","description":"Vitamin A - RE","unit":"RE"},{"id":"urn:uuid:1244bade-5ea7-47e1-825e-ae7e06dd7d04","description":"Vitamin C","unit":"mg"},{"id":"urn:uuid:69c083c9-0d2b-4b36-9b43-f9098c9f293e","description":"Vitamin D - IU","unit":"IU"},{"id":"urn:uuid:74ec6866-463b-4ea4-91fc-f6f9a5a2396e","description":"Vitamin E - IU","unit":"IU"},{"id":"urn:uuid:cf32dd0f-2b4e-4912-844c-76cee5802bdc","description":"Calcium","unit":"mg"},{"id":"urn:uuid:30ae26c2-d1df-4515-a9f1-6fedf5a46a5e","description":"Iron","unit":"mg"},{"id":"urn:uuid:74d1aa06-31c8-4a42-8cd3-2550f674ad03","description":"Potassium","unit":"mg"},{"id":"urn:uuid:4fab08a3-6caa-4d7f-835c-2c18d95eceac","description":"Sodium","unit":"mg"},{"id":"urn:uuid:88c012c8-5d0d-47aa-911e-71f0a8530c8a","description":"Vitamin A - RAE","unit":"RAE"},{"id":"urn:uuid:40a27b38-8ae6-4e22-9e6e-a5f999d8720c","description":"MyPlate - Fruit","unit":"c"},{"id":"urn:uuid:190350b0-7883-456b-a6a8-02118b02e5cc","description":"MyPlate - Dairy","unit":"c"},{"id":"urn:uuid:ccf60586-c74e-4160-b3ee-17fa7d5beb28","description":"MyPlate - Grain Total","unit":"oz-eq"},{"id":"urn:uuid:e6f75496-328d-4852-9f81-b7bea27bfcee","description":"MyPlate - Vegetable Total","unit":"c"},{"id":"urn:uuid:4c903343-a18f-4c14-b791-45435e127b40","description":"MyPlate - Protein Total","unit":"oz-eq"},{"id":"urn:uuid:0d026ef4-2178-464f-933c-dcefecee27c1","description":"Calories from Fat","unit":"kcal"}]';

$nutrients_lookup_table = json_decode( $nutrients_lookup_table, true );

$new = array();

foreach( $nutrients_lookup_table as $nutrient )
{
	$id = $nutrient["id"];
	$temp = array(
		$id => array(
			'description' => $nutrient['description'],
			'unit' => $nutrient['unit']
		)
	);
	$new = array_merge( $new, $temp );
}

$nutrients_lookup_table = $new;
$new = NULL;