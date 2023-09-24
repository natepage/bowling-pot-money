import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    connect() {
        this.form = this.element.querySelector('form');
        this.formName = this.form.getAttribute('name');
        this.achievementsContainer = this.element.querySelector('.achievement-assign-achievement-container');
        this.teamMembersContainer = this.element.querySelector('.achievement-assign-member-container');
        this.achievementInput = this.element.querySelector('#' + this.formName + '_achievementId');
        this.teamMemberInput = this.element.querySelector('#' + this.formName + '_teamMemberId');
    }

    setAchievementInputValue(event) {
        this.achievementInput.value = event.target.getAttribute('data-achievement-id');
    }

    setTeamMemberInputValue(event) {
        this.teamMemberInput.value = event.target.getAttribute('data-member-id');

        // console.

        this.teamMembersContainer.style.display = 'none';
        this.achievementsContainer.style.display = 'block';
    }
}
