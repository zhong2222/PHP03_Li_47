
//GoogleBooks検索
//検索ボタンをクリックしたら
let isbn = [];
$("#send").on("click",function(){
                const url_g = "https://www.googleapis.com/books/v1/volumes?q=";
                $.ajax({
                            url:url_g+$("#key_g").val(),
                            type:'get',
                            cache:false,
                            dataType:'json'
            }).done(function(data) {
                  //書籍名、著者、出版社、サムネイル[リンク]
                  console.log(data);             //オブジェクトの中を確認
                  const len = data.items.length; //データの数を取得
                let html;
                for(let i=0; i<len; i++){
                    // console.log(typeof data.items[i].volumeInfo.publisher);
                    if(typeof data.items[i].volumeInfo.publisher=="undefined"){
                        data.items[i].volumeInfo.publisher="出版社（不明）";
                    }

                    html += `
                        <tr>
                            <td>${data.items[i].volumeInfo.title}</td>
                            <td>${data.items[i].volumeInfo.authors}</td>
                            <td>${data.items[i].volumeInfo.publisher}</td>
                            <td>
                                <a target="_blank" href="${data.items[i].volumeInfo.infoLink}">
                                    <img src="${data.items[i].volumeInfo.imageLinks.thumbnail}">
                                </a>
                            </td>
                            <td><button data-url=${data.items[i].volumeInfo.infoLink}
                                        data-img=${data.items[i].volumeInfo.imageLinks.thumbnail}
                                        data-title=${data.items[i].volumeInfo.title}
                                        data-author=${data.items[i].volumeInfo.authors}
                                        id="select">選択</button>
                            </td>    
                        </tr>
                    `;
                    // isbn.push(data.items[i].volumeInfo.industryIdentifiers[0].identifier);
                }
                    // console.log(isbn);

                  //table要素のid="list"に追加
                $("#list").empty().hide().append(html).fadeIn(1000);
                // $("#list").append(html);

                $(document).on("click", "#select", function () {

                let url=$(this).data("url");                   
                let img=$(this).data("img");
                let title =$(this).data("title");
                let author =$(this).data("author");

                console.log(author);
                thumbnail = 
                        '<a target="_blank" href='+ url + '">'+
                        '<img src=' + img + '">'
                        +'</a>';
                // console.log(thumbnail);
                $("#thumbnail").append(thumbnail );
                $("#title").val(title);
                $("#author").val(author);
                $("#url").val(url);
                });

            });
        });

