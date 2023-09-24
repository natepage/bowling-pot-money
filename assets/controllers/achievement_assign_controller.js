import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    connect() {
        this.form = this.element.querySelector('form');
        this.formName = this.form.getAttribute('name');
        this.achievementInput = this.element.querySelector('#' + this.formName + '_achievementId');
        this.teamMemberInput = this.element.querySelector('#' + this.formName + '_teamMemberId');
    }

    setAchievementInputValue(event) {
        let target = event.target;

        this.achievementInput.value = target.getAttribute('data-achievement-id');
    }

    setTeamMemberInputValue(event) {
        let target = event.target;

        console.log(target);

        this.teamMemberInput.value = target.getAttribute('data-member-id');
    }
}
