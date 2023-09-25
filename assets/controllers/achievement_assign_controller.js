import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    connect() {
        this.form = this.element.querySelector('form');
        this.formName = this.form.getAttribute('name');
        this.achievementsContainer = this.element.querySelector('.achievement-assign-achievement-container');
        this.teamMembersContainer = this.element.querySelector('.achievement-assign-member-container');
        this.submitContainer = this.element.querySelector('.achievement-assign-submit-container');
        this.achievementInput = this.element.querySelector('#' + this.formName + '_achievementId');
        this.teamMemberInput = this.element.querySelector('#' + this.formName + '_teamMemberId');
        this.confirmContainer = this.element.querySelector('.achievement-assign-confirm-container');
        this.confirmMemberText = this.element.querySelector('.achievement-assign-member-confirm-text');
        this.confirmAchievementText = this.element.querySelector('.achievement-assign-achievement-confirm-text');
    }

    reset() {
        this.achievementInput.value = '';
        this.teamMemberInput.value = '';
        this.confirmAchievementText.innerHTML = '';
        this.confirmMemberText.innerHTML = '';

        this.teamMembersContainer.style.display = 'block';
        this.achievementsContainer.style.display = 'none';
        this.confirmContainer.style.display = 'none';
        this.submitContainer.style.display = 'none';
    }

    setAchievementInputValue(event) {
        this.achievementInput.value = event.target.getAttribute('data-achievement-id');
        this.confirmAchievementText.innerHTML = event.target.getAttribute('data-achievement-title');

        this.achievementsContainer.style.display = 'none';
        this.submitContainer.style.display = 'block';
    }

    setTeamMemberInputValue(event) {
        this.teamMemberInput.value = event.target.getAttribute('data-member-id');
        this.confirmMemberText.innerHTML = event.target.getAttribute('data-member-name');

        this.teamMembersContainer.style.display = 'none';
        this.achievementsContainer.style.display = 'block';
        this.confirmContainer.style.display = 'block';
    }

    submit() {
        this.form.submit();
    }
}
