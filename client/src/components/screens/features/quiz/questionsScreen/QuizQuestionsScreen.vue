<template>
  <BackgroundWave />
  <Navigator
      :items="[
        { text: name, to: `/feature/quiz` },
        { text: 'Quiz', to: '' }
      ]"
    />
  QUESTIONSss
</template>

<script>
import BackgroundWave from '@/components/base/backgrounds/wave/BackgroundWave.vue'
import Navigator from '@/components/compositions/navigator/Navigator.vue'

export default {
  name: 'QuizQuestionsScreen',
  components: { BackgroundWave, Navigator },
  data() {
    return {}
  }
}
</script>

<style lang="scss" scoped></style>
