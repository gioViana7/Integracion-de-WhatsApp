<template>
  <div class="container mx-auto px-10">
    <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
      <div class="mb-6 md:flex-1 mt-2 mb:mt-0">
        <label
          class="block text-gray-700 text-sm font-bold mb-2"
          for="message"
        >
          Message
        </label>

        <textarea
          id="message"
          v-model="message"
          name="message"
          rows="3"
          class="w-full shadow-inner p-4 border-2"
          placeholder="Message..."
        />
      </div>

      <div class="mb-6">
        <p class="block text-gray-700 text-sm font-bold mb-2">
          Image
        </p>

        <div class="mt-2 px-4 py-2 bg-gray-300 rounded">
          <button
            class="bg-blue-500
                  hover:bg-blue-700
                  text-white
                  font-bold
                  py-2
                  px-4
                  mb-2
                  rounded
                  focus:outline-none
                  focus:shadow-outline"
            type="button"
            @click="openWidget"
          >
            Upload
          </button>

          <h2>Uploaded:</h2>
          <div
            id="thumb"
            class="feature_thumb"
          />
        </div>
      </div>

      <div class="flex items-center justify-end">
        <button
          class="bg-blue-500
                hover:bg-blue-700
                text-white
                font-bold
                py-2
                px-4
                rounded
                focus:outline-none
                focus:shadow-outline"
          type="button"
          @click="post"
        >
          Post
        </button>
      </div>
    </form>

    <p class="text-center text-gray-500 text-xs">
      ©2019 Poster-App. All rights reserved.
    </p>

    <div
      v-show="showAlert"
      class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md"
      role="alert"
    >
      <div class="flex">
        <div class="py-1">
          <svg
            class="fill-current h-6 w-6 text-teal-500 mr-4"
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 20 20"
          >
            <path
              d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"
            />
          </svg>
        </div>
        <div>
          <p class="font-bold">
            Post published
          </p>
          <a
            class="text-sm"
            :href="linkPost"
          >
            Ver publicacion en Facebook
          </a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
const { cloudinary } = window;

export default {
  data() {
    return {
      message: '',
      paramsToSing: {},
      files: {},
      photoId: [],
      tags: [],
      linkPost: '',
      showAlert: false,
      timeoutID: 0,
    };
  },
  methods: {
    async generateSignature(callback, params = this.paramsToSing) {
      const { data } = await axios.post('cloudinary/signature', params);
      callback(data);
    },
    openWidget() {
      cloudinary.openUploadWidget(
        {
          cloudName: process.env.MIX_CLOUDINARY_CLOUD_NAME,
          apiKey: process.env.MIX_CLOUDINARY_API_KEY,
          uploadSignature: this.generateSignature,
          thumbnails: '.feature_thumb',
          thumbnail_transformation: { width: 100, height: 100, crop: 'fit' },
          resource_type: 'image',
          showAdvancedOptions: true,
        },
        (error, result) => {
          if (!error && result && result.event === 'success') {
            this.files[result.info.public_id] = result.info.url;
          } else if (!error && result && result.event === 'publicid') {
            this.$set(this, 'paramsToSing', Object.assign(this.paramsToSing, { public_id: result.info.id }));
          } else if (!error && result && result.event === 'tags') {
            this.tags = result.info.tags.map((value) => value);
            this.$set(this, 'paramsToSing', Object.assign(this.paramsToSing, { tags: this.tags }));
          }
        },
      );
    },
    async post() {
      await Promise.all(this.publishPhoto(this.files)).then((responses) => {
        responses.forEach((response) => {
          this.photoId.push(response.data.id);
        });
      });

      const params = {};
      params.message = this.message;

      this.photoId.forEach((id, index) => {
        params[`attached_media[${index}]`] = `{"media_fbid":"${id}"}`;
      });

      axios.post('fb/publish/post', params).then((response) => {
        this.linkPost = `https://facebook.com/${response.data.id}`;
        this.showAlert = true;
        window.clearTimeout(this.timeoutID);
        this.timeoutID = setTimeout(() => {
          this.showAlert = false;
          this.linkPost = '';
        }, 10000);
        this.clean();
      });
    },
    publishPhoto(files) {
      const promises = [];
      Object.entries(files).forEach(([caption, url]) => {
        promises.push(axios.post('fb/upload/photo', {
          caption,
          url,
          published: false,
        }));
      });

      return promises;
    },
    clean() {
      this.message = '';
      this.files = {};
      this.paramsToSing = {};
      this.photoId = [];
      this.tags = [];
      const node = document.getElementById('thumb');

      while (node.firstChild) {
        node.removeChild(node.firstChild);
      }
    },
  },
};
</script>
