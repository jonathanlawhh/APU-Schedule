import axios from "axios";

const zeroPad = (num, places) => String(num).padStart(places, '0');

export async function loadSchedule (){
    let schedule = [];
    let d = new Date();
    let timestamp = `${d.getYear()}${d.getMonth()}${ d.getDate() }`;

    if( localStorage.getItem("cache-timestamp") === timestamp ){
        schedule = JSON.parse(localStorage.getItem("cache-schedule"));
    } else {
        await axios.get('https://s3-ap-southeast-1.amazonaws.com/open-ws/weektimetable').then(response => {
            for (let i = 0; i < response.data.length; i++) schedule.push(response.data[i]);
        });

        localStorage.setItem("cache-timestamp", timestamp);
        localStorage.setItem("cache-schedule", JSON.stringify(schedule));
    }
    return schedule;
}

export function getClassroomList(schedule){
    let classrooms = [];
    for (let i = 0; i < schedule.length; i++) classrooms.push( schedule[i].ROOM );
    classrooms = Array.from(new Set(classrooms)).sort();
    return classrooms;
}

export function normalizeTime(t){
    t = t.split(" ");
    t[0] = t[0].replace(":", "");
    return ( t[1] === 'PM' && t[0].substr(0, 2) !== '12' ) ? parseInt(t[0]) + 1200 : parseInt(t[0]); // if PM add 12
}

export function getCurrentTimestamp(){
    let da = new Date();
    return `${ da.getHours() }${ zeroPad( da.getMinutes(), 2) }`;
}
