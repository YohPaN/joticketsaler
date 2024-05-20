<script setup>
import axios from 'axios';
import { ref, onMounted } from 'vue'
import { QrcodeStream } from 'vue-qrcode-reader';
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

/*** detection handling ***/

const result = ref('')
const color = ref('gray-100');
const name = ref('');
const lastName = ref('');
const validationMessage = ref('');
const paused = ref(false);

function onDetect(detectedCodes) {
    console.log('test')
    result.value = JSON.stringify(detectedCodes.map((code) => code.rawValue))
    axios.post(route('ticket-validation'), {id: result.value})
        .then((response) => {
            name.value = response.data.name;
            lastName.value = response.data.lastName;
            validationMessage.value = response.data.validation;
            if(response.data.isValide) {
                color.value = 'success'
            } else {
                color.value = 'danger'
            }
        });

    paused.value = true;
    setTimeout(() => paused.value = false);
}

/***  select camera ***/

const selectedDevice = ref(null)
const devices = ref([])

onMounted(async () => {
    devices.value = (await navigator.mediaDevices.enumerateDevices()).filter(
        ({ kind }) => kind === 'videoinput'
    )

    if (devices.value.length > 0) {
        selectedDevice.value = devices.value[0]
    }
})

/*** track functons ***/

function paintOutline(detectedCodes, ctx) {
    for (const detectedCode of detectedCodes) {
        const [firstPoint, ...otherPoints] = detectedCode.cornerPoints

        ctx.strokeStyle = 'red'

        ctx.beginPath()
        ctx.moveTo(firstPoint.x, firstPoint.y)
        for (const { x, y } of otherPoints) {
        ctx.lineTo(x, y)
        }
        ctx.lineTo(firstPoint.x, firstPoint.y)
        ctx.closePath()
        ctx.stroke()
    }
}
function paintBoundingBox(detectedCodes, ctx) {
    for (const detectedCode of detectedCodes) {
        const {
            boundingBox: { x, y, width, height }
        } = detectedCode

        ctx.lineWidth = 2
        ctx.strokeStyle = '#007bff'
        ctx.strokeRect(x, y, width, height)
    }
}
function paintCenterText(detectedCodes, ctx) {
    for (const detectedCode of detectedCodes) {
        const { boundingBox, rawValue } = detectedCode

        const centerX = boundingBox.x + boundingBox.width / 2
        const centerY = boundingBox.y + boundingBox.height / 2

        const fontSize = Math.max(12, (50 * boundingBox.width) / ctx.canvas.width)

        ctx.font = `bold ${fontSize}px sans-serif`
        ctx.textAlign = 'center'

        ctx.lineWidth = 3
        ctx.strokeStyle = '#35495e'
        ctx.strokeText(detectedCode.rawValue, centerX, centerY)

        ctx.fillStyle = '#5cb984'
        ctx.fillText(rawValue, centerX, centerY)
    }
}
const trackFunctionOptions = [
    { text: 'nothing (default)', value: undefined },
    { text: 'outline', value: paintOutline },
    { text: 'centered text', value: paintCenterText },
    { text: 'bounding box', value: paintBoundingBox }
]
const trackFunctionSelected = ref(trackFunctionOptions[1])

/*** error handling ***/

const error = ref('')

function onError(err) {
    error.value = `[${err.name}]: `

    if (err.name === 'NotAllowedError') {
        error.value += 'you need to grant camera access permission'
    } else if (err.name === 'NotFoundError') {
        error.value += 'no camera on this device'
    } else if (err.name === 'NotSupportedError') {
        error.value += 'secure context required (HTTPS, localhost)'
    } else if (err.name === 'NotReadableError') {
        error.value += 'is the camera already in use?'
    } else if (err.name === 'OverconstrainedError') {
        error.value += 'installed cameras are not suitable'
    } else if (err.name === 'StreamApiNotSupportedError') {
        error.value += 'Stream API is not supported in this browser'
    } else if (err.name === 'InsecureContextError') {
        error.value +=
        'Camera access is only permitted in secure context. Use HTTPS or localhost rather than HTTP.'
    } else {
        error.value += err.message
    }
}

</script>

<template>
    <Head title="Scan" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Scan</h2>
        </template>
        <div class="md:py-12">
            <div class="max-w-7xl mx-auto md:px-6 lg:px-8">

                <div :class="'min-h-screen md:min-h-full md:border md:border-black md:rounded-xl md:w-fit p-10 m-auto bg-' + color">
                        <div>
                            <p>Prenom: {{ name }}</p>
                            <p>Nom: {{ lastName }}</p>
                            <p>Resultat: {{ validationMessage }}</p>
                        </div>

                        <div class="rounded border border-slate-500 border-8 w-full mt-5">
                            <qrcode-stream
                                :constraints="{ deviceId: selectedDevice.deviceId }"
                                :track="trackFunctionSelected.value"
                                :paused="paused"
                                @error="onError"
                                @detect="onDetect"
                                v-if="selectedDevice !== null"
                            />
                            <p v-else class="error">
                                No cameras on this device
                            </p>
                        </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
    .error {
        font-weight: bold;
        color: red;
    }
</style>
