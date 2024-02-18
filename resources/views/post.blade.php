<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Hello, world!</title>
    <style>
        .image-button {
            position: absolute;
            bottom: -50px;
            left: 50%;
            transform: translateX(-50%);
            padding: 10px 50%;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
  </head>
  <body class="container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-sm-12">
                <form action="{{ route('post') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="text" class="form-control" name = "token_acc" hidden value="{{$token}}" >
                    <input type="text" class="form-control" name = "act_id" hidden value="{{$act_id}}" >
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Page select</label>
                        <select class="form-control"  name="page" id="id_page">
                            <option value="">Chọn PAGE</option>
                        @foreach($data as $item) 
                            <option value="{{$item['id']}}">{{$item['name']}}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Caption</label>
                        <textarea class="form-control"  rows="3" name="caption" id="id_caption"></textarea>
                    </div>
                    <div class="form-group">
                        <label >Fake Link</label>
                        <input type="text" class="form-control" name = "fakelink" placeholder="..." id="id_fakelink">
                    </div>
                    <div class="form-group">
                        <label >URL</label>
                        <input type="text" class="form-control" name = "url" placeholder="..." id="id_url">
                    </div>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="imageInput" onchange="handleFileSelect(event)">
                        <label class="custom-file-label" for="imageInput" id="textf">Chọn Ảnh</label>
                        <textarea type="text" id="imagePath" readonly hidden name="image"></textarea>
                        
                    </div>
                    <div class="form-group " style="margin-top: 20px;">
                        <img width="100%" id="viewimage" height="300px" src="" hidden>
                        <button type="submit" class="btn btn-primary image-button" onclick="handleSubmit(event)">Submit</button>
                    </div>
                      <script>
                        function handleFileSelect(event) {
                          const file = event.target.files[0];
                          const reader = new FileReader();
                          const path = URL.createObjectURL(file);
                          reader.onloadend = function() {
                            const base64data = reader.result.split(',')[1];
                            const textf = document.getElementById('textf');
                            textf.textContent = "File: " + file.name;
                            const imagePath = document.getElementById('imagePath');
                            imagePath.textContent = base64data;
                            const viewimage = document.getElementById('viewimage');
                            viewimage.src = path;
                            viewimage.removeAttribute('hidden');
                          };
                          reader.readAsDataURL(file);  
                        }
                        function handleSubmit() {
                            const id_page = document.getElementById('id_page').value;
                            const id_caption = document.getElementById('id_caption').value;
                            const id_fakelink = document.getElementById('id_fakelink').value;
                            const id_url = document.getElementById('id_url').value;
                            const image = document.getElementById('imagePath').value;
                            if (id_page == '' || id_caption == '' || id_fakelink == '' || id_url == '' || image == '' ) {
                                alert("Thông tin không đủ");
                                event.preventDefault();
                            } else {
                                
                            }
                        }
                      </script>
                    
                </form>             
            </div>
        </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>