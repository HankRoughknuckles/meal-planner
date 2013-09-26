$.getScript("/inc/autocomplete.js", function(){
  autocompleteFactory(
    3, "#food-search", "/inc/esha_search_recommendations.php"
  );
});
