<section class="slider_section">
    <div class="slider_container">
      <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <div class="container-fluid">
              <div class="row">
                <div class="col-md-7">
                  <div class="detail-box"> 
                    <h1>
                      Welcome To Our <br>
                      Ecommerce Website
                    </h1>
                    <p>
                     Lorem ipsum dolor sit, amet consectetur adipisicing elit. Inventore perferendis<br>
                      deleniti neque!
                    </p>
                  </div>
                </div>
                <div class="col-md-5 ">
                  @if (file_exists(public_path('asset/store.jpg')))
                    <div class="img-box">
                    <img style="width:600px" src="{{asset('asset/store.jpg')}}" height=" 300"  alt="" />
                  </div>                    
                  @endif
                </div>
              </div>
            </div>
          </div>
          
        </div>
        
      </div>
    </div>
  </section>