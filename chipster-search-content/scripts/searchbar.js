
     


function handleSearch(event) {
  if (event.keyCode === 13) { // 13 is the Enter key code
    const searchBoxValue = document.getElementById("search-input").value;
    const url = `http://localhost:9000/data?searchbox="${encodeURIComponent(searchBoxValue)}"`;
    window.location.href = url;
  }
}

    var searchTimeout = null;
    var searchContainer = document.querySelector(".search-container")
      var searchClose = document.querySelector(".hidden")
      var resultsContainer = document.getElementById("results");
      var searchInput = document.getElementById("search-input");

      searchContainer.addEventListener("click", function(){
        searchClose.classList.toggle("hidden")
      })
      searchClose.addEventListener("click", function(){
        searchClose.classList.remove("hidden");
        resultsContainer.innerHTML = ""
        searchInput.value = ""
      })
      resultsContainer.addEventListener("click", function(event) {
        console.log('hello')
          if (event.target.classList.contains("result-item")) {
            console.log(event.target.innerText)
               const searchBoxValue = event.target.innerText;
            const url = `http://localhost:9000/data?searchbox="${encodeURIComponent(searchBoxValue)}"`;
            window.location.href = url;
        }
        });

        function checkOpenSearchStatus() {
          fetch('http://localhost:9200')
              .then(response => {
                  if (response.ok) {
                      // OpenSearch is running
                      searchInput.removeAttribute('disabled');
                      searchInput.placeholder = 'Search...';
                      clearInterval(checkStatusInterval);
                  } else {
                      // OpenSearch is not running
                      searchInput.setAttribute('disabled', true);
                      searchInput.placeholder = 'Chipster Search is starting... Please Wait';
                  }
              })
              .catch(error => {
                  // Error occurred (OpenSearch not running or other issue)
                  searchInput.setAttribute('disabled', true);
                  searchInput.placeholder = 'Chipster Search is starting... Please Wait';
              });
      }
        
        // Check OpenSearch status initially
        checkOpenSearchStatus();
        const checkInterval = 2500; // milliseconds
        const checkStatusInterval = setInterval(checkOpenSearchStatus, checkInterval);

    function searchOpensearch() {
            clearTimeout(searchTimeout);

            var username = "admin";
            var password = "admin";
            var url = "http://localhost:9200";
            var index = "chipsterindex";
            var searchInput = document.getElementById("search-input");
            var searchTerm = searchInput.value;
            var query = {
                "query": {
                "bool": {
                    "must": [
                    {
                        "bool": {
                        "should": [
                            {
                            "multi_match": {
                                "query": searchTerm,
                                "fields": ["title^7", "filedetails^4", "artists^3", "album^2", "imgtags^1"],
                                "type": "cross_fields",
                                "operator": "or"
                            }
                            },
                            {
                            "multi_match": {
                                "query": searchTerm,
                                "fields": ["title^7", "filedetails^4", "artists^3", "album^2", "imgtags^1"],
                                "type": "phrase",
                                "operator": "or"
                            }
                            },
                            {
                            "multi_match": {
                                "query": searchTerm,
                                "fields": ["title^7", "filedetails^4", "artists^3", "album^2", "imgtags^1"],
                                "type": "phrase_prefix",
                                "operator": "or"
                            }
                            }
                        ],
                      
                        }
                    }
                    ]
                }
                },
                "size": 6,
                "_source": {
                "includes": ["title", "filedetails"],
                "excludes": []
                }
            };

            searchTimeout = setTimeout(function () {
                fetch(url + "/" + index + "/_search", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Authorization": "Basic " + btoa(username + ":" + password)
                },
                body: JSON.stringify(query)
                })
                .then(function (response) {
                    return response.json();
                })
                .then(function (data) {
                    displayResults(data, searchTerm);
                })
                .catch(function (error) {
                    console.error(error);
                });
            }, 300);
            }


    
    function countMatches(text, searchTerm) {
      var regex = new RegExp(searchTerm, 'gi');
      if(!text || text===undefined|| text==="") return 0;
      var matches = text.match(regex);
      return matches ? matches.length : 0;
    }
    
    function displayResults(response, searchTerm) {
      // var resultsContainer = document.getElementById("results");
      resultsContainer.innerHTML = "";
      
      var hits = response.hits.hits;
      hits.forEach(function(hit) {
        var titleMatches = countMatches(hit._source.title, searchTerm);
        var filedetailsMatches = countMatches(hit._source.filedetails, searchTerm);
        
        let resultItem = document.createElement("div");
        
        
        //console.log(titleMatches,filedetailsMatches,'titleMatches,filedetailsMatches')
        if (titleMatches>0 || filedetailsMatches===0) {
          resultItem.textContent = hit._source.title?hit._source.title.substring(0,150):hit._source.title ;
          //console.log(resultItem.textContent,'title')
        } else {
          resultItem.textContent = hit._source.filedetails?hit._source.filedetails.substring(0,150):hit._source.filedetails;
          //console.log(resultItem.textContent,'filedetails')
        }
        
        var icon = document.createElement("img");
        icon.src = "./images/search.svg"
        icon.className = "search-logo-inside uil uil-search";
        resultItem.className= "search-new-items result-item"
        resultsContainer.appendChild(icon);
        resultsContainer.appendChild(resultItem);

        if(titleMatches>0){
            resultItem.addEventListener("click", function() {
          //handleMouseClick(hit._source.title);
            });
        }
        else {
            resultItem.addEventListener("click", function() {
          //handleMouseClick(hit._source.filedetails);
            });
        }


          });
    }
