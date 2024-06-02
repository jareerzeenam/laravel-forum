import moment from "moment";

const relativeDate = (date) => {
    return moment(date).fromNow();
}

export { relativeDate };
