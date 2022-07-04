<template>
  <div>
    <h1>Job Posting Lists</h1>
    <table class="table table-hover">
      <thead>
        <tr>
          <td>
            <div class="form-group">
              <input type="text" class="form-control" placeholder="Input Job Name" v-model="form.job_name">
            </div>
          </td>
          <td>
            <div class="form-group">
              <input type="text" class="form-control" placeholder="Input Job Description" v-model="form.job_description">
            </div>
          </td>
          <td>
            <div class="form-group">
              <input type="number" class="form-control" placeholder="Input Vacants" v-model="form.vacants">
            </div>
          </td>
          <td>
            <div class="form-group">
              <button class="btn btn-primary btn-sm" @click="submit"><i class="fa-solid fa-plus"></i></button>
            </div>
          </td>
        </tr>
      </thead>
      <thead>
        <tr>
          <th>Job Name</th>
          <th>Job Desciption</th>
          <th>Vacants</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, index) in postingList" :key="item.id">
          <td>{{ item.job_name }}</td>
          <td>{{ item.job_description }}</td>
          <td>{{ item.vacants }}</td>
          <td>
            <button class="btn btn-secondary btn-sm" @click="edit(item)"><i class="fa-solid fa-pen-to-square"></i></button>
            <button class="btn btn-danger btn-sm" @click="deletepost(item.id, index)"><i class="fa-solid fa-trash-can"></i></button>
          </td>
        </tr>
      </tbody>
    </table>
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="">Job Name</label>
              <input type="text" class="form-control" v-model="formEdit.job_name">
            </div>
            <div class="form-group">
              <label for="">Job Description</label>
              <input type="text" class="form-control" v-model="formEdit.job_description">
            </div>
            <div class="form-group">
              <label for="">Vacants</label>
              <input type="number" class="form-control" v-model="formEdit.vacants">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" @click="save()">Save changes</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    props: ['posting'],
    data() {
      return {
        postingList: this.posting,
        form: {
          job_name: null,
          job_description: null,
          vacants: 0
        },
        formEdit: {
          job_name: null,
          job_description: null,
          vacants: 0
        },
        editSelectedId: null,
      }
    },
    methods: {
      submit() {
        const vm = this;
        axios.post('/job_posting/p', this.form).then(function (response) {
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Job Post Successfully Saved',
            showConfirmButton: false,
            timer: 1500
          })
          vm.postingList.push(response.data.data);
          vm.form.job_name = null
          vm.form.job_description = null
          vm.form.vacants = 0
          console.log(response.data.data);
        })
        .catch(function (error) {
          alert('something went wrong');
          console.log(error);
        });
      },
      deletepost(post_id, index) {
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
            axios.post('/job_posting/delete/' + post_id).then(function (response) {
              console.log(response);
              vm.postingList.splice(index, 1);
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
      edit(item) {
        const vm = this;
        $('#editModal').modal('show');
        vm.formEdit.job_name = item.job_name;
        vm.formEdit.job_description = item.job_description;
        vm.formEdit.vacants = item.vacants;
        vm.editSelectedId = item.id;
      },
      save() {
        const vm = this;
        axios.post(`/job_posting/edit/${vm.editSelectedId}`, this.formEdit).then(function (response) {
          location.reload();
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Job Post Successfully Edited',
            showConfirmButton: false,
            timer: 1500
          })
        })
        .catch(function (error) {
          alert('something went wrong');
          console.log(error);
        });
      }
    }
  }
</script>