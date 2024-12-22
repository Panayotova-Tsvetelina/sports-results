<template>
    <div class="container">
        <h1 class="title">Football Tournaments</h1>
        <div v-if="loading" class="loading">Loading...</div>
        <div v-else-if="error" class="alert alert-danger">{{ error }}</div>
        <div v-else>
            <div v-for="tournament in tournaments" :key="tournament.id" class="tournament-section">
                <h2 class="tournament-name">{{ tournament.name }}</h2>
                <div v-for="season in tournament.seasons" :key="season.id" class="season-section">
                    <h3 class="season-name">{{ season.name }}</h3>
                    <div class="matches">
                        <div v-for="game in season.games" :key="game.id" class="match-card">
                            <div class="match-info">
                                <!-- Team 1 Name -->
                                <span class="team-name team1">{{ game.team1.name }}</span>

                                <!-- Score -->
                                <span class="score">
                                    {{ game.result ? game.result.team1_score : 'N/A' }} -
                                    {{ game.result ? game.result.team2_score : 'N/A' }}
                                </span>

                                <!-- Team 2 Name -->
                                <span class="team-name team2">{{ game.team2.name }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            tournaments: [],
            loading: false,
            error: null,
        };
    },
    mounted() {
        this.fetchData();
        setInterval(this.fetchData, 60000);
    },
    methods: {
        async fetchData() {
            this.loading = true;
            this.error = null;
            try {
                const response = await fetch('/api/tournaments');
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                const data = await response.json();
                this.tournaments = data.tournaments;
            } catch (err) {
                this.error = 'Failed to load data: ' + err.message;
            } finally {
                this.loading = false;
            }
        },
    },
};
</script>
