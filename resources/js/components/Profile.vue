<style>
  .widget-user-header {
    background-size: cover !important;
    height: 250px !important;
  }
  .widget-user .card-footer {
    padding-top: 5px;
  }
</style>

<template>
  <div class="container">
    <div class="row mt-3">
      <div class="col-md-4">
        <div class="card card-widget widget-user">
          <div class="widget-user-header text-white" style="background: url('./img/shooting.png') center center;">
            <h3 class="widget-user-username text-right">Elizabeth Pierce</h3>
            <h5 class="widget-user-desc text-right">Web Designer</h5>
          </div>
          <div class="widget-user-image">
            <img class="img-circle" :src="getProfilePhoto()" alt="User Avatar">
          </div>
          <div class="card-footer">
            <div class="row">
              <div class="col-sm-4 border-right">
                <div class="description-block">
                  <h5 class="description-header">3,200</h5>
                  <span class="description-text">SALES</span>
                </div>
              </div>
              <div class="col-sm-4 border-right">
                <div class="description-block">
                  <h5 class="description-header">13,000</h5>
                  <span class="description-text">FOLLOWERS</span>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="description-block">
                  <h5 class="description-header">35</h5>
                  <span class="description-text">PRODUCTS</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-8">
        <div class="card card-primary">
          <div class="card-header" style="background-color: #3f51b1;">
            <h3 class="card-title my-1">Update Account Info</h3>
          </div>
          <form>
            <div class="card-body">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" v-model="form.name">
                    <HasError :form="form" field="name" />
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" v-model="form.email">
                    <HasError :form="form" field="email" />
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" v-model="form.username">
                    <HasError :form="form" field="username" />
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="bio">Bio/Experience</label>
                <textarea class="form-control" rows="2" placeholder="Enter ..." id="bio" name="bio" v-model="form.bio"></textarea>
              </div>
              <div class="form-group" style="width: 31%;">
                <label for="photo" class="form-label">Upload Photo</label>
                <input class="form-control" type="file" id="photo" name="photo" accept="image/*" @change="updatePhoto">
              </div>
              <div class="form-group">
                <label for="password">Password (Leave empty if not changing)</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" v-model="form.password">
                <HasError :form="form" field="password" />
              </div>
            </div>
            <div class="card-footer">
              <button type="submit" class="btn btn-success" @click.prevent="updateInfo">Update</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import Form from 'vform';
  import Swal from 'sweetalert2';
  export default {
    data() {
      return {
        form: new Form({
          name: null,
          email: null,
          username: null,
          bio: null,
          password: null,
          photo: null,
        }),
      }
    },

    methods: {
      updatePhoto(e) {
        let file = e.target.files[0];
        let reader = new FileReader();
        
        if(file['size'] < 2111775){
          reader.onloadend = (file) => {
            this.form.photo = reader.result;
          }
          reader.readAsDataURL(file);

        }else{
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'You are uploading a large file',
          })
        }
      },

      updateInfo() {
        this.form.put('api/updateProfile')
        .then(() => {
          Swal.fire({
            icon: 'success',
            title: 'Success',
            text: 'Information updated successfully!',
          })
        })
        .catch(() => {

        })
      },
    },

    created() {
      axios.get('api/profile')
      .then(({ data }) => (this.form.fill(data)));
    },

    mounted() {
      console.log('Component mounted.')
    }
  }
</script>