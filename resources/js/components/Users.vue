<template>
  <div class="container">
    <div class="row mt-5">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Users Table</h3>
            <div class="card-tools">
              <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                <i class="fa-solid fa-user-plus"></i>
              </button>
            </div>
          </div>
          <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Type</th>
                  <th>Registered At</th>
                  <th>Modify</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(user, index) in users" :key="user.id">
                  <td>{{ user.id }}</td>
                  <td>{{ user.name }}</td>
                  <td>{{ user.email }}</td>
                  <td>{{ user.type | upText }}</td>
                  <td>{{ user.created_at | myDate }}</td>
                  <td>
                    <button class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal"><i class="fa-solid fa-pen-to-square" @click="edit(user, index)"></i></button>
                    <button class="btn btn-danger btn-sm" @click="deleteUser(user.id, index)"><i class="fa-solid fa-trash-can"></i></button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add New User</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
            <form @submit.prevent="createUser">
              <div class="modal-body">
                <div class="mb-3">
                  <input id="name" v-model="form.name" type="text" name="name" class="form-control" placeholder="Name">
                  <HasError :form="form" field="name" />
                </div>
                <div class="mb-3">
                  <input id="email" v-model="form.email" type="email" name="email" class="form-control" placeholder="Email">
                  <HasError :form="form" field="email" />
                </div>
                <div class="mb-3">
                  <input id="username" v-model="form.username" type="text" name="username" class="form-control" placeholder="Username">
                  <HasError :form="form" field="username" />
                </div>
                <div class="mb-3">
                  <textarea class="form-control" id="bio" name="bio" rows="3" style="resize:none;" placeholder="Short bio for user (Optional)" v-model="form.bio"></textarea>
                  <HasError :form="form" field="bio" />
                </div>
                <div class="mb-3">
                  <select class="form-select" name="type" id="type" v-model="form.type">
                    <option selected disabled>Select User Role</option>
                    <option value="admin">Admin</option>
                    <option value="user">Standard User</option>
                    <option value="author">Author</option>
                  </select>
                  <HasError :form="form" field="type" />
                </div>
                <div class="mb-3">
                  <input id="password" v-model="form.password" type="password" name="password" class="form-control" placeholder="Password">
                  <HasError :form="form" field="password" />
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Create</button>
              </div>
            </form>
        </div>
      </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit User Information</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
            <form @submit.prevent="saveEdit">
              <div class="modal-body">
                <div class="mb-3">
                  <input id="editName" v-model="formEdit.name" type="text" name="name" class="form-control" placeholder="Name">
                  <HasError :form="form" field="name" />
                </div>
                <div class="mb-3">
                  <input id="editEmail" v-model="formEdit.email" type="email" name="email" class="form-control" placeholder="Email">
                  <HasError :form="form" field="email" />
                </div>
                <div class="mb-3">
                  <input id="editUsername" v-model="formEdit.username" type="text" name="username" class="form-control" placeholder="Username">
                  <HasError :form="form" field="username" />
                </div>
                <div class="mb-3">
                  <textarea class="form-control" id="editBio" name="bio" rows="3" style="resize:none;" placeholder="Short bio for user (Optional)" v-model="formEdit.bio"></textarea>
                  <HasError :form="form" field="bio" />
                </div>
                <div class="mb-3">
                  <select class="form-select" name="type" id="editType" v-model="formEdit.type">
                    <option value="user" selected disabled>Select User Role</option>
                    <option value="admin">Admin</option>
                    <option value="user">Standard User</option>
                    <option value="author">Author</option>
                  </select>
                  <HasError :form="form" field="type" />
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Update</button>
              </div>
            </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import Form from 'vform';
  import Swal from 'sweetalert2'
  export default {
    data() {
      return {
        users: {},
        form: new Form({
          name: null,
          email: null,
          username: null,
          bio: null,
          type: null,
          password: null,
          photo: null,
        }),
        formEdit: new Form({
          name: null,
          email: null,
          username: null,
          bio: null,
          type: null,
        }),
        editSelectedId: null,
        editSelectedIndex: null,
      }
    },
    methods: {
      fetchUsers() {
        axios.get('api/user').then(({ data }) => (this.users = data.data));
      },

      createUser() {
        const vm = this;
        this.form.post('api/user').then(function (data) {
          vm.users.unshift(data.data);
          vm.form.name = null
          vm.form.email = null
          vm.form.username = null
          vm.form.bio = null
          vm.form.type = null
          vm.form.password = null
          vm.form.photo = null
          $('#addModal').modal('hide');
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'New User Created Sucessfully',
            showConfirmButton: false,
            timer: 1500
          })
          console.log(data.data);
        })
        .catch(() => {

        });
      },

      deleteUser(userId, index) {
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            const vm = this;
            axios.delete('api/user/' + userId).then(function (data) {
              vm.users.splice(index, 1);
            })
            .catch(function (error) {
              console.log(error.response);
            });
            Swal.fire(
              'Deleted!',
              'Your record has been deleted.',
              'success'
            )
          }
        })
      },

      edit(user, index) {
        const vm = this;
        vm.formEdit.name = user.name;
        vm.formEdit.email = user.email
        vm.formEdit.username = user.username;
        vm.formEdit.bio = user.bio;
        vm.formEdit.type = user.type;
        vm.editSelectedId = user.id;
        vm.editSelectedIndex = index;
      },

      saveEdit() {
        const vm = this;
        this.formEdit.put('api/user/' + vm.editSelectedId, this.formEdit).then(function (response) {
          location.reload();
          $('#editModal').modal('hide');
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'User Information Successfully Edited',
            showConfirmButton: false,
            timer: 1500
          })
        })
        .catch(() => {

        });
      },

    },
    created() {
      this.fetchUsers();
    }
  }
</script>