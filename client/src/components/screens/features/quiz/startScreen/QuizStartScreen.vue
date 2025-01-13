<template>
  <div class="start_container">
    <BackgroundWave />
    <Navigator
      :items="[
        { text: name, to: `/feature/quiz` },
        { text: 'Quiz', to: '' }
      ]"
    />
    <main class="start_content">
      <h1>Quiz</h1>
      <h2 class="capitalize">{{ name }}</h2>
      <h3 class="capitalize">{{ questionsLength }} questions</h3>
      <Jumbotron title="Get Ready" info="Once start you can't go back.">
        <div class="image_container">
          <img src="@/assets/quiz-image-1.png" alt="" width="174" />
          <img src="@/assets/quiz-image-2.png" alt="" width="174" />
        </div>
        <Badge class="badge"></Badge>
        <BaseButton :theme="BUTTON_THEMES.SECONDARY" @click="start">Start</BaseButton>
      </Jumbotron>
    </main>
  </div>
</template>

<script>
// CONFIGURATIONS
import { THEMES as BUTTON_THEMES } from '@/components/base/button/config.js'

// COMPONENTS
import BackgroundWave from '@/components/base/backgrounds/wave/BackgroundWave.vue'
import BaseButton from '@/components/base/button/BaseButton.vue'
import Jumbotron from '@/components/base/jumbotron/Jumbotron.vue'
import Badge from '@/assets/badge.svg?component'

// COMPOSITIONS
import Navigator from '@/components/compositions/navigator/Navigator.vue'

export default {
  name: 'QuizStartScreen',
  emits: ['start'],
  components: { BaseButton, Jumbotron, BackgroundWave, Badge, Navigator },

  data() {
    return {
      BUTTON_THEMES
    }
  },
  props: {
    name: {
      type: String,
      default: 'Quiz name'
    },
    questionsLength: {
      type: Number,
      default: 10
    }
  },
  methods: {
    start() {
      this.$emit('start')
    }
  }
}
</script>
<style lang="scss" scoped>
@import '@/utilities/css/vars/vars.scss';

.start_container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  color: #343a41;
}

.start_content {
  margin-block: 100px auto;
  display: flex;
  flex-direction: column;
  align-items: center;
  width: 100%;
  gap: 1.2rem;
}

.image_container {
  display: flex;
  justify-content: space-evenly;
  width: 100%;
  gap: 8px;
  margin-block-end: 15px;
}

.badge {
  margin-block-start: -45px;
  background: white;
  border-radius: 50px;
  padding: 6px;
}
</style>
