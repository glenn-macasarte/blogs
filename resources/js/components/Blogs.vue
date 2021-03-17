<template>
  <div>
    <h2>Leave a Reply</h2>
    <form @submit.prevent="addComment" class="mb-2">
      <div class="alert alert-success" v-show="success">Comment added successfully.</div>
      <div class="form-group mb-2 col-sm-6">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" name="name" v-model="name" required>
      </div>

      <div class="form-group mb-2">
        <label for="comment">Comment</label>
        <textarea class="form-control" id="comment" rows="3" name="comment" v-model="comment" required></textarea>
      </div>

      <button type="submit" class="btn btn-primary">POST COMMENT</button>
    </form>

    <div class="card mb-2" v-for="(comment, index) in comments" v-bind:key="index">
      <div class="card-header">
        {{ comment.name }} <span style="font-size: 12px; color: gray; font-style: italic;">{{ comment.created_at }}</span>
      </div>

      <div class="card-body">
        <blockquote class="blockquote mb-0">
          <p>{{ comment.comment }}</p>
          <button v-on:click="isHidden = false">Reply</button>
        </blockquote>
      </div>

      <div class="card mb-2 col-sm-10" style="margin-left: 15%" v-for="(sec_comm, index2) in comment.sec" v-bind:key="index2">
        <div class="card-header">
          {{ sec_comm.name }} <span style="font-size: 12px; color: gray; font-style: italic;">{{ sec_comm.created_at }}</span>
        </div>

        <div class="card-body">
          <blockquote class="blockquote mb-0">
            <p>{{ sec_comm.comment }}</p>
          </blockquote>
        </div>
      </div>

      <form @submit.prevent="addReply" class="mb-2" v-if="!isHidden">
        <div class="alert alert-success" v-show="success">Comment added successfully.</div>
        <div class="form-group mb-2 col-sm-6">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="reply_name" v-model="reply_name" required>
        </div>

        <div class="form-group mb-2">
            <label for="comment">Comment</label>
            <textarea class="form-control" id="comment" rows="3" name="reply_comment" v-model="reply_comment" required></textarea>
        </div>

        <button type="submit" class="btn btn-secondary">REPLY</button>
      </form>
    </div>
  </div>
</template>

<script>
  export default {
    data: function() {
      return {
        comments: [],
        name: '',
        comment: '',
        blog_id: 1,
        success: false,
        isHidden: true
      }
    },

    mounted() {
      this.loadComments();
    },

    methods: {
      // get comments through api
      loadComments: function() {
        axios.get('/api/comments')
        .then((response) => {
          this.comments = response.data;
        })
        .catch(function (error) {
          console.log(error);
        });
      },

      // add comments using api
      addComment: function() {
        axios.post('/api/comments/new', {
          name: this.name,
          comment: this.comment,
          blog_id: this.blog_id
        })
        .then((response) => {
          this.name = '';
          this.comment = '';
          this.success = true;
          this.loadComments();
        })
        .catch(function (error) {
          console.log(error);
        })
      }
    }
  }
</script>